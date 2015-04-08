#!/usr/bin/python

# netcfg -- Network Configuration Tool
# Copyright (C) 1996 Red Hat, Inc
#
# This program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 675 Mass Ave, Cambridge, MA 02139, USA.


import string

from Tkinter import *
from rhtkinter import *
from buttonbar import *
from foldertabs import *
from rhutil import *
from rhdialog import Dialog
from rhentry import *
from textbox import *
from listbox import *
from Conf import *

import rhdialog
import os
from sys import exit
import posixpath
import regex
import regsub
import glob

VERSION = "2.22"
COPYRIGHT = "Copyright (C) 1996, 1997, 1998, 1999, 2000 Red Hat, Inc.\nRedistributable under the terms of the GNU General Public License"

print "Red Hat Linux netcfg", VERSION
print COPYRIGHT


# convert ascii IP address to 32-bit numeric IP
def inet_aton(aIP):
    part = aIP
    nIP = 0
    if not regex.search('[^0-9.]', aIP) == -1:
	raise 'BadAddress'
    while part:
	nIP = (nIP << 8) + string.atoi(regsub.gsub('\..*', '', part))
	if regex.search('\.', part) == -1:
	    part = ''
	else:
	    part = regsub.gsub('^[^\.]+\.', '', part)
    return nIP

# convert 32-bit numeric IP to ascii
def inet_ntoa(nIP):
    return str((nIP >> 24) & 0xFF) + '.' + \
	   str((nIP >> 16) & 0xFF) + '.' + \
	   str((nIP >> 8) & 0xFF) + '.' + \
	   str(nIP & 0xFF)

# get a partial IP number: as much of the network address as is specified in
# the netmask
def partialip(network, netmask):
    if not network or not netmask:
        return ''
    i = 32
    network = inet_aton(network)
    netmask = inet_aton(netmask)
    while not netmask & 1:
	netmask = netmask >> 1
	i = i - 1
    i = i / 8
    string = ''
    while i:
        string = string + str((network >> (8*i)) & 0xFF) + '.'
	i = i - 1
    return string


# merge items from list2 into list1 without duplicates.
# Assumes that list1 doesn't have duplicates already.
def mergeLists(list1, list2):
    for item in list2:
	if not item in list1:
	    list1.append(item)


# compare: returns 1 if same, 0 if not
def compare(a, b):
    if not cmp(a, b):
	return 1
    else:
	return 0

# returns changes boolean to 'yes' or 'no'.
def yn(b):
    if b:
	return 'yes'
    else:
	return 'no'

def isyes(s):
    return compare(s, 'yes') or compare(s, 'true')


# ppp device names are logical, so we need to translate between
# logical and the arbitrarily-assigned system "physical" names.

def ppp_log_to_phys(logical):
    try:
	f = open('/var/run/ppp-'+logical+'.dev')
	physical = f.read()
	while physical[-1] == '\n':
	    physical = physical[:-1]
	return physical
    except:
	return ''

def ppp_phys_to_log(physical):
    try:
	d = os.listdir('/var/run')
	c = regex.compile('^ppp-\(.*\)\.dev$')
	for name in d:
	    if c.search(name) >= 0:
		logical = regsub.sub(c, '\\1', name)
		if not cmp(ppp_log_to_phys(logical), physical):
		    return logical
    except:
	return ''

def LinespeedMenu(variable, master=None, width='20'):
	speedlist = []
	for speed in ['1200', '2400', '4800', '9600', '19200', '38400',
			'57600', '115200']:
	    speedlist.append(['command', {'label':speed,
		'command':lambda x=variable,y=speed: x.set(y)}])
	return LabelledMenu(master, 'Line speed:', variable, width, speedlist)

def ModemportMenu(variable, master=None, width='20'):
	portlist = []
	try:
	    mouse = os.path.split(os.readlink('/dev/mouse'))[1]
	except:
	    mouse = ""
	portalias = {'ttyS0':'cua0', 'ttyS1':'cua1', 'ttyS2':'cua2', 'ttyS3':'cua3'}
	for port in ['modem', 'ttyS0', 'ttyS1', 'ttyS2', 'ttyS3']:
	    portpath = '/dev/'+port
	    if not portalias.has_key(port): portalias[port] = None
	    if os.path.exists(portpath) and not (port == mouse) and \
		not (portalias[port] == mouse):
		portlist.append(['command', {'label':portpath,
		    'command':lambda x=variable,y=portpath: x.set(y)}])
	return LabelledMenu(master, 'Modem Port:', variable, width, portlist)

class GV:
    # for holding "global" variables
    def __init__(self):
	# populate variable space with variables from various config files
	self.Networks = ConfESNetwork()
	self.EHosts = ConfEHosts()
	self.EResolv = ConfEResolv()
	self.ESStaticRoutes = ConfESStaticRoutes()
	self.PAP = ConfPAP()
	if self.EResolv['domain']:
	    # old (broken) resolv.conf -- fix it behind the user's
	    # back, including writing the fixed file, and then
	    # continue.  I normally dislike writing files without
	    # telling users, but this is fixing a bug which we may
	    # have created in the first place, and the fix cannot
	    # make things worse in any way.
	    if not self.EResolv['search'] or \
               not cmp(self.EResolv['search'][0], self.EResolv['domain']):
		if not self.EResolv['search']:
		    self.EResolv['search'] = self.EResolv['domain']
		else:
		    self.EResolv['search'][:0] = self.EResolv['domain']
	    del self.EResolv['domain']
	    try:
		self.EResolv.write()
	    except:
		print 'Permission denied: cannot fix /etc/resolv.conf.'
		print 'Please re-run netcfg as root.'
		exit(0)

	# Also need to fix old ifcfg-lo0 files, turning them into ifcfg-lo.
	# Also done behind user's back, since it's fixing a bug of ours...
	if os.path.exists('/etc/sysconfig/network-scripts/ifcfg-lo0'):
	  try:
	    if os.path.exists('/etc/sysconfig/network-scripts/ifcfg-lo'):
		os.unlink('/etc/sysconfig/network-scripts/ifcfg-lo0')
	    else:
		os.rename('/etc/sysconfig/network-scripts/ifcfg-lo0',
			  '/etc/sysconfig/network-scripts/ifcfg-lo')
	  except:
		print 'Permission denied: cannot fix ifcfg-lo0'
		print 'Please re-run netcfg as root.'
		exit(0)

	# All BOOTP instances should be changed to BOOTPROTO instances,
	# again behind the user's back.
	# This should not happen for clone devices, though...
	for cfg in os.listdir('/etc/sysconfig/network-scripts/'):
	    if cfg[0:6] == 'ifcfg-' and \
		regex.search('[^-]-[^-][^-]*-[^-]', cfg) == -1:
		f = ConfShellVar('/etc/sysconfig/network-scripts/'+cfg)
		f.fsf()
		if not len(f['BOOTPROTO']):
		    # the BOOTPROTO variable doesn't exist; build from BOOTP
		    if not cmp(f['BOOTP'], 'yes'):
			f['BOOTPROTO'] = 'bootp'
		    else:
			f['BOOTPROTO'] = 'none'
		# Now delete those BOOTP variables
		if len(f['BOOTP']):
		    del f['BOOTP']
		f.write()

	# get list of devices in /proc/net/dev...
	self.devs = []
	pppdevs = []
	f = os.popen('cat /proc/net/dev | tail +3 | cut -d: -f1 | ' +
		     'awk \'{print $1}\' | grep -v dummy')
	ppp = regex.compile('^ppp[0-9]')
	for item in f.readlines():
	    item = item[:-1]
	    if ppp.search(item) >= 0:
		logicalname = ppp_phys_to_log(item)
		if logicalname:
		    pppdevs.append(logicalname)
	    else:
		self.devs.append(item)
	f.close()

	# ...merge all possible devices to load from /etc/conf.modules into
	# self.devs list...
	if os.path.exists('/etc/conf.modules'):
	    f = os.popen('grep ^alias /etc/conf.modules | ' +
		 	 'awk \'$2 ~ /(eth)|(tr)|(arc)|(atp)|(plip)/ {print $2}\'')
	    for item in f.readlines():
		mergeLists(self.devs, [item[0:len(item)-1],])
	    f.close

	# ...and now create the list of all running devices (self.runningdevs)
	self.runningdevs = []
	for device in self.devs:
	    if not os.system('/sbin/ifconfig '+device+
			     ' 2>&1 | grep RUNNING 2>&1 >/dev/null'):
		self.runningdevs.append(device)
	for device in pppdevs:
	    if not os.system('/sbin/ifconfig '+ppp_log_to_phys(device)+
			     ' 2>&1 | grep RUNNING 2>&1 >/dev/null'):
		self.runningdevs.append(device)
		self.devs.append(device)

	# Now get list of *configured* interfaces, whether or not they exist...
	self.iflist = []
	rpm = regex.compile('rpm\(orig\|save\|new\)$')
	lo = regex.compile('^lo0$')
	backup = regex.compile('\(~\|.[bB][aA][kK]\|.orig\)$')
	for file in glob.glob1('/etc/sysconfig/network-scripts/', 'ifcfg-*'):
	    # get rid of rpmsave, rpmorig, etc. files, and ignore any old lo0
	    if rpm.search(file) == -1 and lo.search(file) == -1 and \
		backup.search(file) == -1:
		self.iflist.append(regsub.gsub('ifcfg-', '', file))

    def save(self):
	try:
	    self.Networks.write()
	    self.EHosts.write()
	    self.EResolv.write()
	    self.ESStaticRoutes.write()
	    self.PAP.write()
	except:
	    # Cheating; could *possibly* be something other than permission.
	    Dialog('Error', 'Permission denied:\ncan\'t write configuration files.\n' +
		  'Please re-run netcfg as root.', 'warning', 0, ['Ok']).num


class SubFrame(RHFrame):
    # abstract class to derive switched subwindows from
    def show(self):
	self.pack({'expand':'1', 'fill':'both'})
    def hide(self):
	self.forget()

class Names(SubFrame):
    def SPverify(self, event):
	# verify that keypress is valid.  If not, delete it and complain.
	# event.keysym is key pressed
	# self.SPTextBox.index('insert')
	pass

    def NSverify(self, event):
	# verify that keypress is valid.  If not, delete it and complain.
	# event.keysym is key pressed
	# self.NSTextBox.index('insert')
	pass

    def __init__(self, Master, GV):
	self.G = GV
	self.hostname = StringVar(Master)
	self.hostname.set(self.G.Networks['HOSTNAME'])
	self.domain = StringVar(Master)
	if self.G.EResolv['search']:
	    self.domain.set(self.G.EResolv['search'][0])
	SubFrame.__init__(self, Master)
	LabelledEntry(self, 'Hostname:', self.hostname, '12').pack(
	  {'side':'top', 'fill':'x'})
	LabelledEntry(self, 'Domain:', self.domain, '12').pack(
	  {'side':'top', 'fill':'x'})
	Label(self, {'text':'Search for hostnames in additional domains:'}).pack(
	  {'side':'top', 'anchor':'w'})
	SPF = RHFrame(self)
	Label(SPF, {'text':'', 'width':'12', 'anchor':'w'}).pack(
	  {'side':'left'})
	self.SPTextBox = VScrolledTextBox(SPF, {'height':'4'})
	for search in self.G.EResolv['search'][1:]:
	    self.SPTextBox.insert('end', search + '\n')
	self.SPTextBox.bind('<Any-Key>', self.SPverify)
	self.SPTextBox.pack({'side':'top', 'fill':'both', 'expand':'1'})
	SPF.pack({'side':'top', 'fill':'both'})
	NSF = RHFrame(self)
	Label(NSF, {'text':'Nameservers:', 'width':'12', 'anchor':'nw'}).pack(
	  {'side':'left', 'anchor':'nw'})
	self.NSTextBox = VScrolledTextBox(NSF, {'height':'3'})
	for nameserver in self.G.EResolv['nameservers']:
	    self.NSTextBox.insert('end', nameserver + '\n')
	self.NSTextBox.bind('<Any-Key>', self.NSverify)
	self.NSTextBox.pack({'fill':'both', 'expand':'1'})
	NSF.pack({'fill':'both', 'expand':'1'})

    def save(self):
	self.G.Networks['HOSTNAME'] = self.hostname.get()
	os.system('hostname ' + self.hostname.get())
	text = regsub.gsub('[\n\t ]+$', '', self.SPTextBox.get('0.1', 'end'))
	self.G.EResolv['search'] = [self.domain.get()] + regsub.split(text, '[\n\t ]+')
	# in case we are creating /etc/resolve.conf; go to the end of the file
	self.G.EResolv.fsf()
	text = regsub.gsub('[\n\t ]+$', '', self.NSTextBox.get('0.1', 'end'))
	self.G.EResolv['nameservers'] = regsub.split(text, '[\n\t ]+')


class Hosts(SubFrame):
    def edit(self, index = -1):
	self.saveindex = index
	self.T = Toplevel()
	self.T.title('Edit /etc/hosts')
	self.ipaddr = StringVar(self.T)
	self.name = StringVar(self.T)
	self.nicknames = StringVar(self.T)
	self.replace = 0
	if index >= 0:
	    self.replace = 1
	    item = self.HostBox.getItems(index)
	    self.ipaddr.set(item[0])
	    self.name.set(item[1])
	    self.nicknames.set(item[2])
	F = RHFrame(self.T)
	LabelledEntry(F, 'IP:', self.ipaddr, '15').pack(
	  {'side':'top', 'expand':'1', 'fill':'x'})
	LabelledEntry(F, 'Name:', self.name, '15').pack(
	  {'side':'top', 'expand':'1', 'fill':'x'})
	LabelledEntry(F, 'Nicknames:', self.nicknames, '15').pack(
	  {'side':'top', 'expand':'1', 'fill':'x'})
	BB = ButtonBar(F)
	BB.setOrientation('horizontal')
	BB.addButton('Done', self.setEntry)
	BB.addButton('Cancel', self.T.destroy)
	BB.pack({'side':'bottom'})
	F.pack({'side':'top', 'expand':'1', 'fill':'both'})
	self.T.update()
	self.T.grab_set()
	self.T.wait_window(self.T)
	self.T.grab_release()
    def addEntry(self):
	self.edit()
    def editEntry(self):
	if not self.HostBox.getSelectedItems():
	    return
	return self.edit(string.atoi(self.HostBox.curselection()[0]))
    def setEntry(self):
	if not self.ipaddr.get() or not self.name.get():
	    Dialog('Error', 'Need both name and IP address', 'warning', 0, ['Ok']).num
	    return
	if self.replace:
	    self.HostBox.delete(self.saveindex)
	else:
	    # Not replacing; must be new; should go at the end
	    self.saveindex = 'end'
	    self.G.EHosts.fsf()
	self.HostBox.insert((self.ipaddr.get(), self.name.get(),
                             self.nicknames.get()), self.saveindex)
	self.HostBox.selectLine(self.saveindex)
	self.G.EHosts[self.ipaddr.get()] = [self.name.get(),
				regsub.split(self.nicknames.get(), '[\t ]+')]
	self.T.destroy()
    def removeEntry(self):
	item = self.HostBox.getSelectedItems()
	if not item:
	    return
	item = item[0][0]
	i = self.HostBox.curselection()[0]
	i = string.atoi(i)
	self.HostBox.delete(i)
	if self.HostBox.getItems(i):
	    self.HostBox.selectLine(i)
	del self.G.EHosts[item]
    def editOnclick(self, entry):
	return self.editEntry()

    def __init__(self, Master, GV):
	self.G = GV
	SubFrame.__init__(self, Master)
	self.HostBox = MultifieldListbox(self,
		[('IP', 15, 0), ('Name', 25, 1), ('Nicknames', 25, 1)])
	for ip in self.G.EHosts.keys():
	    self.HostBox.insert((ip, self.G.EHosts[ip][0],
				     joinfields(self.G.EHosts[ip][1][0:], ' ')))
	self.HostBox.bind('<Double-Button-1>', self.editOnclick)
	BB = ButtonBar(self)
	BB.setOrientation('horizontal')
	BB.addButton('Add', self.addEntry)
	BB.addButton('Edit', self.editEntry)
	BB.addButton('Remove', self.removeEntry)
	self.HostBox.pack({'side':'top', 'expand':'1', 'fill':'both'})
	BB.pack({'side':'bottom'})

    def save(self):
	for line in self.HostBox.getAllItems():
	     self.G.EHosts[line[0]] = [line[1], regsub.split(line[2], '[\t ]+')]


class Interfaces(SubFrame):
    def editBus(self, interface, index = -1, bootp = 1):
	self.interface = interface
	self.saveindex = index
	self.bootpallowed = bootp
	self.T = Toplevel()
	self.T.title('Edit Ethernet/Bus Interface')
	self.onboot = IntVar(self.T)
	self.userctl = IntVar(self.T)
	self.bootproto = StringVar(self.T)
	self.ipaddr = StringVar(self.T)
	self.netmask = StringVar(self.T)
	self.network = ' '
	self.broadcast = ' '
	self.replace = 0

	self.clone = 0
	if string.find(interface, '-') != -1:
	    self.clone = 1
	    cloned, clonename = tuple(string.split(interface, '-', 1))

	if not self.cfgfiles.has_key('ifcfg-'+interface):
	    # set defaults in config file
	    if self.clone:
		if not self.cfgfiles.has_key('ifcfg-'+cloned):
		    self.cfgfiles['ifcfg-'+cloned] = \
			ConfShellVar(
			    '/etc/sysconfig/network-scripts/ifcfg-'+cloned)
		self.cfgfiles['ifcfg-'+interface] = \
		    ConfShellVarClone(self.cfgfiles['ifcfg-'+cloned],
			'/etc/sysconfig/network-scripts/ifcfg-'+interface)
		# Clone devices must ALWAYS default to not coming up
		# at boot time.  Users change that at their own risk.
		self.cfgfiles['ifcfg-'+interface]['ONBOOT'] = 'no'
	    else:
		self.cfgfiles['ifcfg-'+interface] = \
		    ConfShellVar(
			'/etc/sysconfig/network-scripts/ifcfg-'+interface)

	cf=self.cfgfiles['ifcfg-'+interface]
	if self.clone:
	    cf['DEVICE'] = cloned
	else:
	    cf['DEVICE'] = interface
	self.ipaddr.set(cf['IPADDR'])
	self.netmask.set(cf['NETMASK'])
	self.network = cf['NETWORK']
	self.broadcast = cf['BROADCAST']
	self.onboot.set(isyes(cf['ONBOOT']))
	self.userctl.set(isyes(cf['USERCTL']))
	self.bootproto.set(cf['BOOTPROTO'])

	if index >= 0:
	    self.replace = 1
	    self.ipaddr.set(cf['IPADDR'])
	else:
	    if regex.search(':', interface) != -1:
		# Note: this only gets called to when the alias is created
		aliasedinterface = regsub.sub(':.*', '', interface)
		# can't alias clone devices, so don't need to look for one
		if not self.cfgfiles.has_key('ifcfg-'+aliasedinterface):
		    self.cfgfiles['ifcfg-'+aliasedinterface] = \
			ConfShellVar(
			    '/etc/sysconfig/network-scripts/ifcfg-'+aliasedinterface)
        	self.netmask.set(self.cfgfiles['ifcfg-'+aliasedinterface]['NETMASK'])
        	self.ipaddr.set(partialip(
		    self.cfgfiles['ifcfg-'+aliasedinterface]['NETWORK'],
		    self.cfgfiles['ifcfg-'+aliasedinterface]['NETMASK']))
		self.onboot.set(isyes(
		    self.cfgfiles['ifcfg-'+aliasedinterface]['ONBOOT']))
		self.userctl.set(isyes(
		    self.cfgfiles['ifcfg-'+aliasedinterface]['USERCTL']))


	F = RHFrame(self.T)
	Label(F, {'text':'Device: '+self.interface, 'relief':'groove'}).pack(
	  {'side':'top', 'pady':'6', 'ipady':'2', 'ipadx':'8'})
	IP = LabelledEntry(F, 'IP:', self.ipaddr, '15')
	IP.bind('<Return>', self.setBusLabels)
	IP.bind('<Leave>', self.setBusLabels)
	IP.bind('<Enter>', self.setBusLabels)
	IP.bind('<Tab>', self.setBusLabels)
	IP.pack({'side':'top', 'expand':'1', 'fill':'x'})
	Netmask = LabelledEntry(F, 'Netmask:', self.netmask, '15')
	Netmask.bind('<Return>', self.setBusLabels)
	Netmask.bind('<Leave>', self.setBusLabels)
	Netmask.bind('<Enter>', self.setBusLabels)
	Netmask.bind('<Tab>', self.setBusLabels)
	Netmask.pack({'side':'top', 'expand':'1', 'fill':'x'})
	self.Network = LabelledLabel(F, 'Network:', self.network, '15')
	self.Network.pack({'side':'top', 'expand':'1', 'fill':'x'})
	self.Broadcast = LabelledLabel(F, 'Broadcast:', self.broadcast, '15')
	self.Broadcast.pack({'side':'top', 'expand':'1', 'fill':'x'})
	Checkbutton(F, {'text':'Activate interface at boot time',
			     'variable':self.onboot}).pack(
	  {'side':'top', 'anchor':'w'})
	Checkbutton(F, {'text':'Allow any user to (de)activate interface',
			     'variable':self.userctl}).pack(
	  {'side':'top', 'anchor':'w'})
	if self.bootpallowed:
	    LabelledMenu(F, 'Interface configuration protocol',
			 self.bootproto, '30',
			 (('command', {'label':'none', 'command':lambda x=self:x.bootproto.set('none')}),
			  ('command', {'label':'DHCP', 'command':lambda x=self:x.bootproto.set('dhcp')}),
			  ('command', {'label':'BOOTP', 'command':lambda x=self:x.bootproto.set('bootp')}))
			).pack(
	      {'side':'top', 'anchor':'w'})
	BB = ButtonBar(F)
	BB.setOrientation('horizontal')
	BB.addButton('Done', self.setBus)
	BB.addButton('Cancel', self.T.destroy)
	BB.pack({'side':'bottom'})
	F.pack({'side':'top', 'expand':'1', 'fill':'both'})
	self.T.update()
	self.T.grab_set()
	self.T.wait_window(self.T)
	self.T.grab_release()
    def setBusLabels(self, event=None):
	# if self.ipaddr and self.netmask are both set,
	#  set self.network and self.broadcast
	#  call self.Network.settext()and self.Broadcast.settext()
	ip = self.ipaddr.get()
	if len(ip) > 6:
	    ip = inet_aton(ip)
	else:
	    ip = 0
	mask = self.netmask.get()
	if len(mask) > 8:
	    mask = inet_aton(mask)
	else:
	    mask = 0
	if ip:
	    if not mask:
		first = ((ip >> 24) & 0xFF)
		if first <= 127:
		    self.netmask.set('255.0.0.0')
		elif first <= 191:
		    self.netmask.set('255.255.0.0')
		else:
		    self.netmask.set('255.255.255.0')
	    mask = inet_aton(self.netmask.get())
	    # both IP and mask are set; set network and broadcast
	    self.network = inet_ntoa(ip & mask)
	    self.broadcast = inet_ntoa((ip & mask) | ~mask)
	    self.Network.settext(self.network)
	    self.Broadcast.settext(self.broadcast)
    def setBus(self):
	if Dialog('Save?', 'Save current configuration?',
		  'question', 0, ['Save', 'Cancel']).num:
	    return
	if self.replace:
	    active = self.IFBox.getItems(self.saveindex)[4]
	    self.IFBox.delete(self.saveindex)
	else:
	    # must be new since it's not a replacement
	    self.saveindex = 'end'
	    active = 'no'

	cf = self.cfgfiles['ifcfg-'+self.interface]
	cf.fsf()
	cf['IPADDR'] = self.ipaddr.get()
	cf['NETMASK'] = self.netmask.get()
	cf['NETWORK'] = self.network
	cf['BROADCAST'] = self.broadcast
	cf['BOOTPROTO'] = self.bootproto.get()
	cf['ONBOOT'] = yn(self.onboot.get())
	cf['USERCTL'] = yn(self.userctl.get())
	self.IFBox.insert((self.interface,
			   cf['IPADDR'],
			   cf['BOOTPROTO'],
			   cf['ONBOOT'],
			   active), self.saveindex)
	self.IFBox.selectLine(self.saveindex)
	self.listdevs.append(self.interface)
	# Should this offer to activate the interface if it is
	# inactive, and restart it if it is?
	# FIXME: finish this job...
	self.save()
	cf.write()
	self.T.destroy()

    def editPLIP(self, interface, index = -1):
	self.interface = interface
	self.saveindex = index
	self.T = Toplevel()
	self.T.title('Edit PLIP Interface')
	self.onboot = IntVar(self.T)
	self.userctl = IntVar(self.T)
	self.ipaddr = StringVar(self.T)
	self.remip = StringVar(self.T)
	self.netmask = StringVar(self.T)
	self.network = ' '
	self.replace = 0

	self.clone = 0
	if string.find(interface, '-') != -1:
	    self.clone = 1
	    cloned, clonename = tuple(string.split(interface, '-', 1))

	if index >= 0:
	    self.replace = 1
	    item = self.IFBox.getItems(index)
	    self.ipaddr.set(item[1])

	if not self.cfgfiles.has_key('ifcfg-'+interface):
	    if self.clone:
		if not self.cfgfiles.has_key('ifcfg-'+cloned):
		    self.cfgfiles['ifcfg-'+cloned] = \
			ConfShellVar(
			    '/etc/sysconfig/network-scripts/ifcfg-'+cloned)
		self.cfgfiles['ifcfg-'+interface] = \
		    ConfShellVarClone(self.cfgfiles['ifcfg-'+cloned],
			'/etc/sysconfig/network-scripts/ifcfg-'+interface)
		# Clone devices must ALWAYS default to not coming up
		# at boot time.  Users change that at their own risk.
		self.cfgfiles['ifcfg-'+interface]['ONBOOT'] = 'no'
	    else:
		self.cfgfiles['ifcfg-'+interface] = \
		    ConfShellVar(
			'/etc/sysconfig/network-scripts/ifcfg-'+interface)
		self.cfgfiles['ifcfg-'+interface] = \
		  ConfShellVar('/etc/sysconfig/network-scripts/ifcfg-' + interface)
	cf = self.cfgfiles['ifcfg-'+interface]
	self.ipaddr.set(cf['IPADDR'])
	self.remip.set(cf['REMIP'])
	self.netmask.set(cf['NETMASK'])
	self.network = cf['NETWORK']
	self.onboot.set(isyes(cf['ONBOOT']))
	self.userctl.set(isyes(cf['USERCTL']))

	F = RHFrame(self.T)
	IF = Label(F, {'text':'Device: '+self.interface, 'relief':'groove'})
	IF.pack({'side':'top', 'pady':'6', 'ipady':'2', 'ipadx':'8'})
	IP = LabelledEntry(F, 'IP:', self.ipaddr, '15')
	IP.bind('<Return>', self.setPLIPLabels)
	IP.pack({'side':'top', 'expand':'1', 'fill':'x'})
	IP = LabelledEntry(F, 'Remote IP:', self.remip, '15')
	IP.pack({'side':'top', 'expand':'1', 'fill':'x'})
	Netmask = LabelledEntry(F, 'Netmask:', self.netmask, '15')
	Netmask.bind('<Return>', self.setPLIPLabels)
	Netmask.pack({'side':'top', 'expand':'1', 'fill':'x'})
	self.Network = LabelledLabel(F, 'Network:', self.network, '15')
	self.Network.pack({'side':'top', 'expand':'1', 'fill':'x'})
	OB = Checkbutton(F, {'text':'Activate interface at boot time',
			     'variable':self.onboot})
	OB.pack({'side':'top', 'anchor':'w'})
	Checkbutton(F, {'text':'Allow any user to (de)activate interface',
			     'variable':self.userctl}).pack(
	  {'side':'top', 'anchor':'w'})
	BB = ButtonBar(F)
	BB.setOrientation('horizontal')
	BB.addButton('Done', self.setPLIP)
	BB.addButton('Cancel', self.T.destroy)
	BB.pack({'side':'bottom'})
	F.pack({'side':'top', 'expand':'1', 'fill':'both'})
	self.T.update()
	self.T.grab_set()
	self.T.wait_window(self.T)
	self.T.grab_release()
    def setPLIPLabels(self, event=None):
	# if self.ipaddr and self.netmask are both set,
	#  set self.network and self.broadcast
	#  call self.Network.settext()and self.Broadcast.settext()
	ip = self.ipaddr.get()
	if len(ip) > 6:
	    ip = inet_aton(ip)
	else:
	    ip = 0
	mask = self.netmask.get()
	if len(mask) > 8:
	    mask = inet_aton(mask)
	else:
	    mask = 0
	if ip:
	    if not mask:
		first = ((ip >> 24) & 0xFF)
		if first <= 127:
		    self.netmask.set('255.0.0.0')
		elif first <= 191:
		    self.netmask.set('255.255.0.0')
		else:
		    self.netmask.set('255.255.255.0')
	    mask = inet_aton(self.netmask.get())
	    # both IP and mask are set; set network and broadcast
	    self.network = inet_ntoa(ip & mask)
	    self.Network.settext(self.network)
    def setPLIP(self):
	if Dialog('Save?', 'Save current configuration?',
		  'question', 0, ['Save', 'Cancel']).num:
	    return
	if self.replace:
	    active = self.IFBox.getItems(self.saveindex)[4]
	    self.IFBox.delete(self.saveindex)
	else:
	    # must be new since it's not a replacement
	    self.saveindex = 'end'
	    active = 'no'
	# now actually munge all the files...  Yuck!
	cf = self.cfgfiles['ifcfg-'+self.interface]
	cf.fsf()
	cf['DEVICE'] = self.interface
	cf['IPADDR'] = self.ipaddr.get()
	cf['REMIP'] = self.remip.get()
	cf['NETMASK'] = self.netmask.get()
	cf['NETWORK'] = self.network
	cf['ONBOOT'] = yn(self.onboot.get())
	cf['USERCTL'] = yn(self.userctl.get())
	cf['BOOTPROTO'] = 'none'
	self.IFBox.insert((self.interface,
			   cf['IPADDR'],
			   cf['BOOTPROTO'],
			   cf['ONBOOT'],
			   active), self.saveindex)
	self.IFBox.selectLine(self.saveindex)
	self.listdevs.append(self.interface)
	# Should this offer to activate the interface if it is
	# inactive, and restart it if it is?
	# FIXME: finish this job...
	self.save()
	cf.write()
	self.T.destroy()


    def PPPinit(self, interface):
	self.L = Toplevel()
	self.L.title('Create PPP Interface')
	self.pppnext = ''
	phonenum = StringVar(self.L)
	login = StringVar(self.L)
	password = StringVar(self.L)
	pap = IntVar(self.L)
	F = RHFrame(self.L)
	Label(F, {'text':'Device: '+self.interface, 'relief':'groove'}).pack(
	  {'side':'top', 'pady':'6', 'ipady':'2', 'ipadx':'8'})
	LabelledEntry(F, 'Phone Number:', phonenum, '20').pack(
	  {'side':'top', 'anchor':'w', 'expand':'1', 'fill':'x'})
	Checkbutton(F, {'text':'Use PAP authentication', 'variable':pap}).pack(
	  {'side':'top', 'anchor':'w'})
	LabelledEntry(F, 'PPP login name:', login, '20').pack(
	  {'side':'top', 'anchor':'w', 'expand':'1', 'fill':'x'})
	LabelledEntry(F, 'PPP password:', password, '20').pack(
	  {'side':'top', 'anchor':'w', 'expand':'1', 'fill':'x'})
	BB = ButtonBar(F)
	BB.setOrientation('horizontal')
	BB.addButton('Done', self.PPPinitdone)
	BB.addButton('Customize', self.PPPinitcustomize)
	BB.addButton('Cancel', self.PPPinitcancel)
	BB.pack({'side':'bottom'})
	F.pack({'side':'top', 'expand':'1', 'fill':'both'})
	self.L.update()
	self.L.grab_set()
	self.L.wait_window(self.L)
	self.L.grab_release()
	return (self.pppnext, phonenum.get(), login.get(), password.get(), pap.get())
    def PPPinitdone(self):
	self.pppnext = 'done'
	self.L.destroy()
    def PPPinitcustomize(self):
	self.pppnext = 'customize'
	self.L.destroy()
    def PPPinitcancel(self):
	self.pppnext = 'cancel'
	self.L.destroy()

    def showHardware(self):
	self.currentframe.hide()
	self.currentframe = self.HWF
	self.HWF.show()
    def showCommunication(self):
	self.currentframe.hide()
	self.currentframe = self.CMF
	self.CMF.show()
    def showNetworking(self):
	self.currentframe.hide()
	self.currentframe = self.NTF
	self.NTF.show()
    def showPAP(self):
	self.currentframe.hide()
	self.currentframe = self.PAP
	self.PAP.show()

    def editPPP(self, interface, index = -1):
	self.interface = interface
	self.saveindex = index
	self.T = Toplevel()
	self.T.title('Edit PPP Interface')
	self.T.withdraw()
	self.hardflowctl = IntVar(self.T)
	self.defabort = IntVar(self.T)
	self.escapechars = IntVar(self.T)
	self.linespeed = StringVar(self.T)
	self.modemport = StringVar(self.T)
	self.pppoptions = StringVar(self.T)
	self.initstring = StringVar(self.T)
	self.dialcmd = StringVar(self.T)
	self.phonenum = StringVar(self.T)
	self.debug = IntVar(self.T)
	self.onboot = IntVar(self.T)
	self.defroute = IntVar(self.T)
	self.persist = IntVar(self.T)
	self.userctl = IntVar(self.T)
	self.retrytimeout = StringVar(self.T)
	self.disconnecttimeout = StringVar(self.T)
	self.mru = StringVar(self.T)
	self.mtu = StringVar(self.T)
	self.ipaddr = StringVar(self.T)
	self.remip = StringVar(self.T)
	self.papname = StringVar(self.T)
	self.replace = 0
	chatdefaults = 0
	action = ''
	pap = 1

	if index >= 0:
	    # editing
	    self.replace = 1


	self.clone = 0
	if string.find(interface, '-') != -1:
	    self.clone = 1
	    cloned, clonename = tuple(string.split(interface, '-', 1))

	if not self.cfgfiles.has_key('ifcfg-'+interface):
	    # set defaults in config file
	    if self.clone:
		if not self.cfgfiles.has_key('ifcfg-'+cloned):
		    self.cfgfiles['ifcfg-'+cloned] = \
			ConfShellVar(
			    '/etc/sysconfig/network-scripts/ifcfg-'+cloned)
		self.cfgfiles['ifcfg-'+interface] = \
		    ConfShellVarClone(self.cfgfiles['ifcfg-'+cloned],
			'/etc/sysconfig/network-scripts/ifcfg-'+interface)
		# Clone devices must ALWAYS default to not coming up
		# at boot time.  Users change that at their own risk.
		self.cfgfiles['ifcfg-'+interface]['ONBOOT'] = 'no'
	    else:
		self.cfgfiles['ifcfg-'+interface] = \
		    ConfShellVar(
			'/etc/sysconfig/network-scripts/ifcfg-'+interface)
	    # This gets the right interface whether it is cloned or not
	    cf = self.cfgfiles['ifcfg-'+interface]
	    if self.clone:
		cf['DEVICE'] = cloned
	    else:
		cf['DEVICE'] = interface
	    cf['HARDFLOWCTL'] = 'yes'
	    cf['DEFABORT'] = 'yes'
	    cf['ESCAPECHARS'] = 'no'
	    cf['LINESPEED'] = '115200'
	    cf['MODEMPORT'] = '/dev/modem'
	    cf['INITSTRING'] = 'ATZ'
	    cf['ONBOOT'] = 'no'
	    cf['DEFROUTE'] = 'yes'
	    cf['PERSIST'] = 'yes'
	    # use defaults when setting up chat box
	    chatdefaults = 1
	else: 
	    cf = self.cfgfiles['ifcfg-'+interface]

	# Only present the shortcut interface if it makes sense to do so.
	phonenum = ''
	if not self.clone and (
 		not os.path.exists(
		    '/etc/sysconfig/network-scripts/chat-'+interface) or
		not self.replace):
	    (action, phonenum, login, passwd, pap) = self.PPPinit(interface)
	    # For people who asked to cancel:
	    if action == 'cancel':
		return

	# and now set up the chatfile
	if self.clone:
	    self.chatfile = ConfChatFileClone(
		ConfChatFile('/etc/sysconfig/network-scripts/chat-'+cloned,
		    cf, self.AbortStrings),
		'/etc/sysconfig/network-scripts/chat-'+interface,
		cf, self.AbortStrings)
	else:
	    self.chatfile = ConfChatFile(
		'/etc/sysconfig/network-scripts/chat-'+interface,
		cf, self.AbortStrings)

	if not self.chatfile.phonenum:
	    self.chatfile.phonenum = phonenum
	if not self.chatfile.dialcmd:
	    self.chatfile.dialcmd = 'ATDT'

	# now, initialize variables from config files
	# (gets previous settings if editing, defaults if new)
	self.hardflowctl.set(compare(cf['HARDFLOWCTL'], 'yes'))
	self.defabort.set(compare(cf['DEFABORT'], 'yes'))
	self.escapechars.set(compare(cf['ESCAPECHARS'], 'yes'))
	self.linespeed.set(cf['LINESPEED'])
	self.modemport.set(cf['MODEMPORT'])
	self.pppoptions.set(cf['PPPOPTIONS'])
	self.initstring.set(cf['INITSTRING'])
	self.debug.set(compare(cf['DEBUG'], 'yes'))
	self.onboot.set(compare(cf['ONBOOT'], 'yes'))
	self.defroute.set(compare(cf['DEFROUTE'], 'yes'))
	self.persist.set(compare(cf['PERSIST'], 'yes'))
	self.userctl.set(compare(cf['USERCTL'], 'yes'))
	self.retrytimeout.set(cf['RETRYTIMEOUT'])
	self.disconnecttimeout.set(cf['DISCONNECTTIMEOUT'])
	self.mru.set(cf['MRU'])
	self.mtu.set(cf['MTU'])
	self.ipaddr.set(cf['IPADDR'])
	self.remip.set(cf['REMIP'])
	self.papname.set(cf['PAPNAME'])

	# delete strings we used to keep in the config file -- potential
	# security hole
	del cf['DIALCMD']
	del cf['PHONENUM']
	self.dialcmd.set(self.chatfile.dialcmd)
	self.phonenum.set(self.chatfile.phonenum)

	TF = RHFrame(self.T)
	FT = FolderTabs(TF)
	FT.addTab('Hardware', self.showHardware, 1)
	FT.addTab('Communication', self.showCommunication)
	FT.addTab('Networking', self.showNetworking)
	FT.addTab('PAP', self.showPAP)
	# Start of Hardware foldertabs label
	self.HWF = SubFrame(TF)
	self.currentframe = self.HWF
	F = self.HWF
	Label(F, {'text':'Device: '+self.interface, 'relief':'groove'}).pack(
	  {'side':'top', 'pady':'6', 'ipady':'2', 'ipadx':'8'})
	Checkbutton(F, {'text':'Use hardware flow control and modem lines',
			     'variable':self.hardflowctl}).pack(
	  {'side':'top', 'anchor':'w'})
	Checkbutton(F, {'text':'Escape control characters',
			     'variable':self.escapechars}).pack(
	  {'side':'top', 'anchor':'w'})
	Checkbutton(F, {'text':'Abort connection on well-known errors',
			     'variable':self.defabort}).pack(
	  {'side':'top', 'anchor':'w'})
	Checkbutton(F, {'text':'Allow any user to (de)activate interface',
			     'variable':self.userctl}).pack(
	  {'side':'top', 'anchor':'w'})
	LinespeedMenu(self.linespeed, F, '20').pack(
	  {'side':'top', 'anchor':'w', 'expand':'1', 'fill':'x'})
	ModemportMenu(self.modemport, F, '20').pack(
	  {'side':'top', 'anchor':'w', 'expand':'1', 'fill':'x'})
	LabelledEntry(F, 'PPP Options:', self.pppoptions, '20').pack(
	  {'side':'top', 'anchor':'w', 'expand':'1', 'fill':'x'})
	# Start of Communication foldertabs label
	self.CMF = SubFrame(TF)
	F = self.CMF
	LabelledEntry(F, 'Modem Init String:', self.initstring, '20').pack(
	  {'side':'top', 'anchor':'w', 'expand':'1', 'fill':'x'})
	LabelledEntry(F, 'Modem Dial Command:', self.dialcmd, '20').pack(
	  {'side':'top', 'anchor':'w', 'expand':'1', 'fill':'x'})
	LabelledEntry(F, 'Phone Number:', self.phonenum, '20').pack(
	  {'side':'top', 'anchor':'w', 'expand':'1', 'fill':'x'})
	Checkbutton(F, {'text':'Debug connection',
			'variable':self.debug}).pack(
	  {'side':'top', 'anchor':'w'})
	self.CB = ChatBox(F)
	if self.chatfile.chatlist:
	    for pair in self.chatfile.chatlist:
		self.CB.insert(pair)
	else:
	    if not pap and index < 0:
		for pair in [('ogin:', login), ('ord:', passwd),
			     ('TIMEOUT', '5'), ('~--', '')]:
		    self.CB.insert(pair)
	self.CB.pack({'side':'top', 'anchor':'w', 'expand':'1', 'fill':'x'})
	# Start of Networking foldertabs label
	self.NTF = SubFrame(TF)
	F = self.NTF
	Checkbutton(F, {'text':'Activate interface at boot time',
			     'variable':self.onboot}).pack(
	  {'side':'top', 'anchor':'w'})
	Checkbutton(F, {'text':'Set default route when making connection (defaultroute)',
			     'variable':self.defroute}).pack(
	  {'side':'top', 'anchor':'w'})
	IF = Frame(F, {'relief':'groove', 'bd':'3'})
	Checkbutton(F, {'text':'Restart PPP when connection fails',
			     'variable':self.persist}).pack(
	  {'side':'top', 'anchor':'w'})
	Label(IF, {'text':'Timeout values in seconds for...', 'anchor':'w'}).pack(
	  {'side':'top', 'anchor':'w', 'expand':'1', 'fill':'x'})
	LabelledEntry(IF, '  no connection:', self.retrytimeout, '20').pack(
	  {'side':'top', 'anchor':'w', 'expand':'1', 'fill':'x'})
	LabelledEntry(IF, '  broken connection:', self.disconnecttimeout, '20').pack(
	  {'side':'top', 'anchor':'w', 'expand':'1', 'fill':'x'})
	IF.pack({'side':'top', 'anchor':'w', 'expand':'1', 'fill':'x'})
	IF = Frame(F, {'relief':'groove', 'bd':'3'})
	Label(IF, {'text':'Maximum packet sizes:', 'anchor':'w'}).pack(
	  {'side':'top', 'anchor':'w', 'expand':'1', 'fill':'x'})
	LabelledEntry(IF, '  MRU (296-1500):', self.mru, '20').pack(
	  {'side':'top', 'anchor':'w', 'expand':'1', 'fill':'x'})
	LabelledEntry(IF, '  MTU (296-1500):', self.mtu, '20').pack(
	  {'side':'top', 'anchor':'w', 'expand':'1', 'fill':'x'})
	IF.pack({'side':'top', 'anchor':'w', 'expand':'1', 'fill':'x'})
	IF = Frame(F, {'relief':'groove', 'bd':'3'})
	Label(IF, {'text':'Infrequently-used options:', 'anchor':'w'}).pack(
	  {'side':'top', 'anchor':'w', 'expand':'1', 'fill':'x'})
	LabelledEntry(IF, '  Local IP address:', self.ipaddr, '20').pack(
	  {'side':'top', 'anchor':'w', 'expand':'1', 'fill':'x'})
	LabelledEntry(IF, '  Remote IP address:', self.remip, '20').pack(
	  {'side':'top', 'anchor':'w', 'expand':'1', 'fill':'x'})
	IF.pack({'side':'top', 'anchor':'w', 'expand':'1', 'fill':'x'})
	# Start of PAP foldertabs label
	self.PAP = SubFrame(TF)
	LabelledEntry(self.PAP, 'Send username', self.papname, '20').pack(
	  {'side':'top', 'anchor':'w', 'expand':'1', 'fill':'x'})
	self.PB = ChatBox(self.PAP, ['Username', 'Secret'])
	if pap and index < 0 and not self.clone:
	    self.papname.set(login)
	    if login or passwd or not self.G.PAP[interface][0]:
		self.G.PAP[interface] = [[login, passwd]]
	if pap:
	    for pair in self.G.PAP[interface]:
		self.PB.insert(pair)
	self.PB.pack({'side':'top', 'anchor':'w', 'expand':'1', 'fill':'x'})
	# End of foldertabs
	BB = ButtonBar(TF)
	BB.setOrientation('horizontal')
	BB.addButton('Done', self.setPPP)
	BB.addButton('Cancel', self.T.destroy)
	BB.pack({'side':'bottom'})

	# For people who asked not to customize:
	if not cmp(action, 'done'):
	    self.setPPP()
	    return

	FT.pack({'side':'top', 'anchor':'nw'})
	TF.pack({'side':'top', 'expand':'1', 'fill':'both'})
	self.currentframe.show()
	self.T.deiconify()
	self.T.update()
	self.T.grab_set()
	self.T.wait_window(self.T)
	self.T.grab_release()
    def setPPP(self):
	if Dialog('Save?', 'Save current configuration?',
		  'question', 0, ['Save', 'Cancel']).num:
	    return
	if self.replace:
	    active = self.IFBox.getItems(self.saveindex)[4]
	    self.IFBox.delete(self.saveindex)
	else:
	    # must be new since it's not a replacement
	    self.saveindex = 'end'
	    active = 'no'
	# now actually munge all the files...  Yuck!
	# start with the standard configuration file, which we know was
	# set up in editPPP()
	cf = self.cfgfiles['ifcfg-'+self.interface]
	if self.hardflowctl.get():
	    cf['HARDFLOWCTL'] = 'yes'
	else:
	    cf['HARDFLOWCTL'] = 'no'
	if self.defabort.get():
	    cf['DEFABORT'] = 'yes'
	else:
	    cf['DEFABORT'] = 'no'
	self.chatfile.defabort = self.defabort.get()
	if self.escapechars.get():
	    cf['ESCAPECHARS'] = 'yes'
	else:
	    cf['ESCAPECHARS'] = 'no'
	cf['LINESPEED'] = self.linespeed.get()
	cf['MODEMPORT'] = self.modemport.get()
	cf['PPPOPTIONS'] = self.pppoptions.get()
	cf['INITSTRING'] = self.initstring.get()
	if not cf['INITSTRING']:
	    cf['INITSTRING'] = 'ATZ'
	self.chatfile.dialcmd = self.dialcmd.get()
	self.chatfile.phonenum = self.phonenum.get()
	cf['IPADDR'] = self.ipaddr.get()
	cf['REMIP'] = self.remip.get()
	cf['PAPNAME'] = self.papname.get()
	if self.debug.get():
	    cf['DEBUG'] = 'yes'
	else:
	    cf['DEBUG'] = 'no'
	if self.onboot.get():
	    cf['ONBOOT'] = 'yes'
	else:
	    cf['ONBOOT'] = 'no'
	if self.defroute.get():
	    cf['DEFROUTE'] = 'yes'
	else:
	    cf['DEFROUTE'] = 'no'
	if self.persist.get():
	    cf['PERSIST'] = 'yes'
	else:
	    cf['PERSIST'] = 'no'
	if self.userctl.get():
	    cf['USERCTL'] = 'yes'
	else:
	    cf['USERCTL'] = 'no'
	cf['RETRYTIMEOUT'] = self.retrytimeout.get()
	cf['DISCONNECTTIMEOUT'] = self.disconnecttimeout.get()
	cf['MRU'] = self.mru.get()
	cf['MTU'] = self.mtu.get()
	cf['BOOTPROTO'] = 'none'
	self.G.PAP[self.interface] = self.PB.getlist()
	# don't break if interface has been touched by rp3
	cf['WVDIALSECT'] = ''
	# now create the chat file contents
	self.chatfile.chatlist = []
	for pair in self.CB.getlist():
	    self.chatfile.chatlist.append(pair)

	self.IFBox.insert((self.interface, cf['IPADDR'], '', cf['ONBOOT'], active),
			  self.saveindex)
	self.IFBox.selectLine(self.saveindex)
	self.listdevs.append(self.interface)
	# Should this offer to activate the interface if it is
	# inactive, and restart it if it is?
	# FIXME: finish this job...
	self.save()
	cf.write()
	self.chatfile.chmod(0600)
	self.chatfile.write()
	self.G.PAP.write()
	self.T.destroy()


    def SLIPinit(self, interface):
	self.L = Toplevel()
	self.L.title('Create SLIP Interface')
	self.slipnext = ''
	phonenum = StringVar(self.L)
	login = StringVar(self.L)
	password = StringVar(self.L)
	F = RHFrame(self.L)
	Label(F, {'text':'Device: '+self.interface, 'relief':'groove'}).pack(
	  {'side':'top', 'pady':'6', 'ipady':'2', 'ipadx':'8'})
	LabelledEntry(F, 'Phone Number:', phonenum, '20').pack(
	  {'side':'top', 'anchor':'w', 'expand':'1', 'fill':'x'})
	LabelledEntry(F, 'SLIP login name:', login, '20').pack(
	  {'side':'top', 'anchor':'w', 'expand':'1', 'fill':'x'})
	LabelledEntry(F, 'SLIP password:', password, '20').pack(
	  {'side':'top', 'anchor':'w', 'expand':'1', 'fill':'x'})
	BB = ButtonBar(F)
	BB.setOrientation('horizontal')
	BB.addButton('Done', self.SLIPinitdone)
	BB.addButton('Cancel', self.SLIPinitcancel)
	BB.pack({'side':'bottom'})
	F.pack({'side':'top', 'expand':'1', 'fill':'both'})
	self.L.update()
	self.L.grab_set()
	self.L.wait_window(self.L)
	self.L.grab_release()
	return (self.slipnext, phonenum.get(), login.get(), password.get())
    def SLIPinitdone(self):
	self.slipnext = 'done'
	self.L.destroy()
    def SLIPinitcancel(self):
	self.slipnext = 'cancel'
	self.L.destroy()

    def editSLIP(self, interface, index = -1):
	self.interface = interface
	self.saveindex = index
	self.T = Toplevel()
	self.T.title('Edit SLIP Interface')
	self.T.withdraw()
	self.linespeed = StringVar(self.T)
	self.modemport = StringVar(self.T)
	self.initstring = StringVar(self.T)
	self.dialcmd = StringVar(self.T)
	self.phonenum = StringVar(self.T)
	self.onboot = IntVar(self.T)
	self.defroute = IntVar(self.T)
	self.persist = IntVar(self.T)
	self.userctl = IntVar(self.T)
	self.mtu = StringVar(self.T)
	self.ipaddr = StringVar(self.T)
	self.remip = StringVar(self.T)
	self.mode = StringVar(self.T)
	self.replace = 0
	chatdefaults = 0
	action = ''

	if index >= 0:
	    # editing
	    self.replace = 1


	self.clone = 0
	if string.find(interface, '-') != -1:
	    self.clone = 1
	    cloned, clonename = tuple(string.split(interface, '-', 1))

	if not self.cfgfiles.has_key('ifcfg-'+interface):
	    # set defaults in config file
	    if self.clone:
		if not self.cfgfiles.has_key('ifcfg-'+cloned):
		    self.cfgfiles['ifcfg-'+cloned] = \
			ConfShellVar(
			    '/etc/sysconfig/network-scripts/ifcfg-'+cloned)
		self.cfgfiles['ifcfg-'+interface] = \
		    ConfShellVarClone(self.cfgfiles['ifcfg-'+cloned],
			'/etc/sysconfig/network-scripts/ifcfg-'+interface)
		# Clone devices must ALWAYS default to not coming up
		# at boot time.  Users change that at their own risk.
		self.cfgfiles['ifcfg-'+interface]['ONBOOT'] = 'no'
	    else:
		self.cfgfiles['ifcfg-'+interface] = \
		    ConfShellVar(
			'/etc/sysconfig/network-scripts/ifcfg-'+interface)
	    cf = self.cfgfiles['ifcfg-'+interface]
	    if self.clone:
		cf['DEVICE'] = cloned
	    else:
		cf['DEVICE'] = interface
	    cf['LINESPEED'] = '115200'
	    cf['MODEMPORT'] = '/dev/modem'
	    cf['INITSTRING'] = 'ATZ'
	    cf['DIALCMD'] = 'ATDT'
	    cf['ONBOOT'] = 'no'
	    cf['DEFROUTE'] = 'yes'
	    cf['PERSIST'] = 'yes'
	    cf['MODE'] = 'SLIP'
	    # use defaults when setting up chat box
	    chatdefaults = 1
	else:
	    cf = self.cfgfiles['ifcfg-'+interface]

	phonenum = ''
	if not self.clone and (
 		not os.path.exists(
		    '/etc/sysconfig/network-scripts/chat-'+interface) or
		not self.replace):
	    (action, phonenum, login, passwd) = self.SLIPinit(interface)
	    # For people who asked to cancel:
	    if not cmp(action, 'cancel'):
		return

	# and now set up the chatfile
	if self.clone:
	    self.chatfile = ConfChatFileClone(
		ConfChatFile('/etc/sysconfig/network-scripts/chat-'+cloned,
		    cf, self.AbortStrings),
		'/etc/sysconfig/network-scripts/chat-'+interface,
		cf, self.AbortStrings)
	else:
	    self.chatfile = ConfChatFile(
		'/etc/sysconfig/network-scripts/chat-'+interface,
		cf, self.AbortStrings)

	if not self.chatfile.phonenum:
	    self.chatfile.phonenum = phonenum
	if not self.chatfile.dialcmd:
	    self.chatfile.dialcmd = 'ATDT'

	# now, initialize variables from config files
	# (gets previous settings if editing, defaults if new)
	cf = self.cfgfiles['ifcfg-'+interface]
	self.linespeed.set(cf['LINESPEED'])
	self.modemport.set(cf['MODEMPORT'])
	self.initstring.set(cf['INITSTRING'])
	self.onboot.set(compare(cf['ONBOOT'], 'yes'))
	self.userctl.set(compare(cf['USERCTL'], 'yes'))
	self.defroute.set(compare(cf['DEFROUTE'], 'yes'))
	self.persist.set(compare(cf['PERSIST'], 'yes'))
	self.mtu.set(cf['MTU'])
	self.ipaddr.set(cf['IPADDR'])
	self.remip.set(cf['REMIP'])
	self.mode.set(cf['MODE'])

	# delete strings we used to keep in the config file -- potential
	# security hole
	del cf['DIALCMD']
	del cf['PHONENUM']
	self.dialcmd.set(self.chatfile.dialcmd)
	self.phonenum.set(self.chatfile.phonenum)


	TF = RHFrame(self.T)
	FT = FolderTabs(TF)
	# borrow the PPP versions of these, since they won't be working
	# at the same time.  Might as well have a similar interface...
	FT.addTab('Hardware', self.showHardware, 1)
	FT.addTab('Communication', self.showCommunication)
	FT.addTab('Networking', self.showNetworking)
	# Start of Hardware foldertabs label
	self.HWF = SubFrame(TF)
	self.currentframe = self.HWF
	F = self.HWF
	Label(F, {'text':'Device: '+self.interface, 'relief':'groove'}).pack(
	  {'side':'top', 'pady':'6', 'ipady':'2', 'ipadx':'8'})
	LinespeedMenu(self.linespeed, F, '20').pack(
	  {'side':'top', 'anchor':'w', 'expand':'1', 'fill':'x'})
	ModemportMenu(self.modemport, F, '20').pack(
	  {'side':'top', 'anchor':'w', 'expand':'1', 'fill':'x'})
	Checkbutton(F, {'text':'Allow any user to (de)activate interface',
			     'variable':self.userctl}).pack(
	  {'side':'top', 'anchor':'w'})
	# Start of Communication foldertabs label
	self.CMF = SubFrame(TF)
	F = self.CMF
	LabelledEntry(F, 'Modem Init String:', self.initstring, '20').pack(
	  {'side':'top', 'anchor':'w', 'expand':'1', 'fill':'x'})
	LabelledEntry(F, 'Modem Dial Command:', self.dialcmd, '20').pack(
	  {'side':'top', 'anchor':'w', 'expand':'1', 'fill':'x'})
	LabelledEntry(F, 'Phone Number:', self.phonenum, '20').pack(
	  {'side':'top', 'anchor':'w', 'expand':'1', 'fill':'x'})
	self.CB = ChatBox(F)
	if self.chatfile.chatlist:
	    for pair in self.chatfile.chatlist:
		self.CB.insert(pair)
	else:
	    for pair in [('ogin:', login), ('ord:', passwd)]:
		self.CB.insert(pair)
	self.CB.pack({'side':'top', 'anchor':'w', 'expand':'1', 'fill':'x'})
	# Start of Networking foldertabs label
	self.NTF = SubFrame(TF)
	F = self.NTF
	Checkbutton(F, {'text':'Activate interface at boot time',
			     'variable':self.onboot}).pack(
	  {'side':'top', 'anchor':'w'})
	Checkbutton(F, {'text':'Set default route when making connection',
			     'variable':self.defroute}).pack(
	  {'side':'top', 'anchor':'w'})
	Checkbutton(F, {'text':'Restart SLIP when connection fails',
			     'variable':self.persist}).pack(
	  {'side':'top', 'anchor':'w'})
	LabelledEntry(F, 'MTU (296-1500):', self.mtu, '20').pack(
	  {'side':'top', 'anchor':'w', 'expand':'1', 'fill':'x'})
	LabelledEntry(F, 'Local IP address:', self.ipaddr, '20').pack(
	  {'side':'top', 'anchor':'w', 'expand':'1', 'fill':'x'})
	LabelledEntry(F, 'Remote IP address:', self.remip, '20').pack(
	  {'side':'top', 'anchor':'w', 'expand':'1', 'fill':'x'})
	sliplist = []
	for type in ['SLIP', 'CSLIP']:
	    sliplist.append(['command', {'label':type,
		'command':lambda x=self,y=type: x.mode.set(y)}])
	LabelledMenu(F, 'Mode:', self.mode, '20', sliplist).pack(
	  {'side':'top', 'anchor':'w', 'expand':'1', 'fill':'x'})
	BB = ButtonBar(TF)
	BB.setOrientation('horizontal')
	BB.addButton('Done', self.setSLIP)
	BB.addButton('Cancel', self.T.destroy)
	BB.pack({'side':'bottom'})
	FT.pack({'side':'top', 'anchor':'nw'})
	TF.pack({'side':'top', 'expand':'1', 'fill':'both'})
	self.currentframe.show()
	self.T.deiconify()
	self.T.update()
	self.T.grab_set()
	self.T.wait_window(self.T)
	self.T.grab_release()
    def setSLIP(self):
	if Dialog('Save?', 'Save current configuration?',
		  'question', 0, ['Save', 'Cancel']).num:
	    return
	if self.replace:
	    active = self.IFBox.getItems(self.saveindex)[4]
	    self.IFBox.delete(self.saveindex)
	else:
	    # must be new since it's not a replacement
	    self.saveindex = 'end'
	    active = 'no'
	# now actually munge all the files...  Yuck!
	# start with the standard configuration file...
	cf = self.cfgfiles['ifcfg-'+self.interface]
	cf.fsf()
	cf['LINESPEED'] = self.linespeed.get()
	cf['MODEMPORT'] = self.modemport.get()
	cf['MODE'] = self.mode.get()
	cf['INITSTRING'] = self.initstring.get()
	if not cf['INITSTRING']:
	    cf['INITSTRING'] = 'ATZ'
	self.chatfile.dialcmd = self.dialcmd.get()
	self.chatfile.phonenum = self.phonenum.get()
	cf['IPADDR'] = self.ipaddr.get()
	cf['REMIP'] = self.remip.get()
	if self.onboot.get():
	    cf['ONBOOT'] = 'yes'
	else:
	    cf['ONBOOT'] = 'no'
	if self.defroute.get():
	    cf['DEFROUTE'] = 'yes'
	else:
	    cf['DEFROUTE'] = 'no'
	if self.persist.get():
	    cf['PERSIST'] = 'yes'
	else:
	    cf['PERSIST'] = 'no'
	if self.userctl.get():
	    cf['USERCTL'] = 'yes'
	else:
	    cf['USERCTL'] = 'no'
	cf['MTU'] = self.mtu.get()
	cf['BOOTPROTO'] = 'none'
	# now create the chat file contents
	self.chatfile.chatlist = []
	for pair in self.CB.getlist():
	    self.chatfile.chatlist.append(pair)

	# set this up to write from the chatfile
	# no need to clone this, since it is never read and would just add
	# complexity to initscripts.
	self.dipfile = ConfDIP(self.chatfile,
			       '/etc/sysconfig/network-scripts/dip-'+self.interface,
			       cf)

	self.IFBox.insert((self.interface, cf['IPADDR'], '', cf['ONBOOT'], active),
			  self.saveindex)
	self.IFBox.selectLine(self.saveindex)
	self.listdevs.append(self.interface)
	# Should this offer to activate the interface if it is
	# inactive, and restart it if it is?
	# FIXME: finish this job...
	self.save()
	cf.write()
	self.chatfile.chmod(0600)
	self.chatfile.write()
	self.dipfile.write()
	self.T.destroy()

    def editInterface(self, interface, index = -1, bootp = 1):
	if index >= 0 and not self.managedDevice(index):
	    Dialog('Error', 'Unmanaged devices cannot be edited through netcfg.',
		   'warning', 0, ['Ok']).num
	    return
	# if no index, then need to find the first open device of that type,
	# unless being called to add an alias or clone, or being called on a
	# PLIP device (blech!)
	# For now, limit searches to 256 devices.
	if index == -1 and regex.search(':', interface) == -1 and \
			   regex.search('-', interface) == -1:
	    if regex.search('^plip', interface) != -1:
		interface = interface + str(
		    Dialog('Info', 'Please choose a PLIP interface:',
			'info', 1, ['plip0', 'plip1', 'plip2']).num)
 	    else:
		# find a new device
		for i in range(256):
		    if not interface + str(i) in self.listdevs:
			interface = interface + str(i)
			break
		else:
		    Dialog('Error', 'All available devices are in use.',
			   'warning', 0, ['Ok']).num
		    return
	if regex.search('^ppp', interface) != -1:
	    self.editPPP(interface, index)
	elif regex.search('^sl', interface) != -1:
	    self.editSLIP(interface, index)
	elif regex.search('^plip', interface) != -1:
	    self.editPLIP(interface, index)
	elif regex.search('^lo', interface) != -1:
	    # If people want to destroy their systems, they will have to
	    # do it without our help...
	    Dialog('Error', 'The loopback device may not be changed.',
		   'warning', 0, ['Ok']).num
	else:
	    # assume it must be a standard device like ethernet
	    self.editBus(interface, index, bootp)

    def addEntry(self):
	self.T = Toplevel()
	self.T.title('Choose Interface Type')
	self.IF = StringVar(self.T)
	self.IF.set('ppp')
	L = Label(self.T, {'text':'Interface Type:'})
	L.pack({'side':'top'})
	Rppp = Radiobutton(self.T, {'text':'PPP', 'variable':self.IF, 'value':'ppp'})
	Rslip = Radiobutton(self.T, {'text':'SLIP', 'variable':self.IF, 'value':'sl'})
	Rplip = Radiobutton(self.T, {'text':'PLIP', 'variable':self.IF, 'value':'plip'})
	Reth = Radiobutton(self.T, {'text':'Ethernet', 'variable':self.IF, 'value':'eth'})
	Rarc = Radiobutton(self.T, {'text':'Arcnet', 'variable':self.IF, 'value':'arc'})
	Rtr = Radiobutton(self.T, {'text':'Token Ring', 'variable':self.IF, 'value':'tr'})
	Ratp = Radiobutton(self.T, {'text':'Pocket (ATP)', 'variable':self.IF, 'value':'atp'})
	Rppp.pack({'side':'top', 'anchor':'w'})
	Rslip.pack({'side':'top', 'anchor':'w'})
	Rplip.pack({'side':'top', 'anchor':'w'})
	Reth.pack({'side':'top', 'anchor':'w'})
	Rarc.pack({'side':'top', 'anchor':'w'})
	Rtr.pack({'side':'top', 'anchor':'w'})
	Ratp.pack({'side':'top', 'anchor':'w'})
	BB = ButtonBar(self.T)
	BB.setOrientation('horizontal')
	BB.addButton('OK', self.setEntry)
	BB.addButton('Cancel', self.T.destroy)
	BB.pack({'side':'bottom'})
	self.T.update()
	self.T.grab_set()
	self.T.wait_window(self.T)
	self.T.grab_release()
    def setEntry(self):
	self.T.destroy()
	self.editInterface(self.IF.get())

    def editEntry(self, event=None):
	if not self.IFBox.getSelectedItems():
	    return
	index = string.atoi(self.IFBox.curselection()[0])
	return self.editInterface(self.IFBox.getItems(index)[0], index)
    def cloneEntry(self, event=None):
	if not self.IFBox.getSelectedItems():
	    return
	index = string.atoi(self.IFBox.curselection()[0])
	orig = self.IFBox.getItems(index)[0]
	# in case the device is a clone already,
	# strip any -.*^ (alias number) off the original interface name.
	orig = regsub.gsub('-.*$', '', orig)
	if regex.search(':', orig) != -1:
	    Dialog('Error', 'Sorry, Device aliases cannot be cloned',
		   'warning', 0, ['Ok']).num
	    return
	if regex.search('^lo', orig) != -1:
	    Dialog('Error', 'Sorry, the loopback device cannot be cloned',
		   'warning', 0, ['Ok']).num
	    return
	name = EntryBox("Name clone device", "Clone name",
			self).get()
	if regex.search('[-:]', name) != -1:
	    Dialog('Error',
		"Sorry, the `-' and `:' characters are not allowed in" +
		" clone names", 'warning', 0, ['Ok'])
	    return
	if name: self.editInterface(orig+'-'+name)
    def aliasEntry(self, event=None):
	if not self.IFBox.getSelectedItems():
	    return
	index = string.atoi(self.IFBox.curselection()[0])
	interface = self.IFBox.getItems(index)[0]
	if regex.search('-', interface) != -1:
	    Dialog('Error', 'Sorry, cloned devices cannot be aliased',
		   'warning', 0, ['Ok']).num
	    return
	# need to find next alias for device...
	# reject loopback aliases
	if regex.match('^lo', interface) >= 2:
	    # This is a silly enough idea we don't even need to pop
	    # up a dialog box...
	    return
	# SLIP interfaces can't be aliased.  Use PPP!
	if regex.match('^sl[0-9]', interface) >= 3:
	    # must be a slip interface
	    Dialog('Error', 'Sorry, SLIP devices cannot be aliased',
		   'warning', 0, ['Ok']).num
	    return
	# in case the device is an alias already,
	# strip any :.*^ (alias number) off the interface name.
	interface = regsub.gsub(':.*$', '', interface)
	# next, iterate through range(256) looking for empty devicename:i
	for i in range(256):
	    if not (interface + ':' + str(i) in self.G.runningdevs or \
	            interface + ':' + str(i) in self.G.iflist or \
                    interface + ':' + str(i) in self.listdevs):
		interface = interface + ':' + str(i)
		break
	else:
	    Dialog('Error', 'All available aliases for this device are in use.',
		   'warning', 0, ['Ok']).num
	    return
	# finally, call self.editBus on that name, telling it not to allow bootp.
	# Aliases don't need to be dialed, and don't need to know remote IPs,
	# and more or less act like ethernet devices
	return self.editBus(interface, -1, 0)
    def removeEntry(self):
	if not self.IFBox.getSelectedItems():
	    return
	index = string.atoi(self.IFBox.curselection()[0])
	device = self.IFBox.getItems(index)[0]
	if self.managedDevice(index) and cmp(device, 'lo'):
	    if Dialog('Remove?', 'Really remove this interface?',
		      'warning', 0, ['Cancel', 'Ok']).num:
		self.deactivateInterface(device, index)
		self.removeInterface(device, index)
    def activateEntry(self):
	if not self.IFBox.getSelectedItems():
	    return
	index = string.atoi(self.IFBox.curselection()[0])
	device = self.IFBox.getItems(index)[0]
	if self.managedDevice(index) and cmp(device, 'lo'):
	    self.activateInterface(device, index)
    def deactivateEntry(self):
	if not self.IFBox.getSelectedItems():
	    return
	index = string.atoi(self.IFBox.curselection()[0])
	device = self.IFBox.getItems(index)[0]
	if self.managedDevice(index) and cmp(device, 'lo'):
	    self.deactivateInterface(device, index)
    def managedDevice(self, index):
	return cmp(self.IFBox.getItems(index)[1], 'unmanaged device')
    def activateInterface(self, device, index):
	if os.path.exists('/etc/sysconfig/network-scripts/ifcfg-' + device):
	    os.system ('/etc/sysconfig/network-scripts/ifup ' +
		       '/etc/sysconfig/network-scripts/ifcfg-' + device)
	    self.IFBox.changeField(index, 4, 'active')
	else:
	    Dialog('Error', 'Device has not been fully configured.\n' +
		   'You must save device configuration before activation.',
		   'warning', 0, ['Ok']).num
    def deactivateInterface(self, device, index):
	if os.path.exists('/etc/sysconfig/network-scripts/ifcfg-' + device):
	    os.system ('/etc/sysconfig/network-scripts/ifdown ' +
		       '/etc/sysconfig/network-scripts/ifcfg-' + device)
	self.IFBox.changeField(index, 4, 'inactive')
    def removeInterface(self, device, index):
	if os.path.exists('/etc/sysconfig/network-scripts/ifcfg-' + device):
	    os.unlink('/etc/sysconfig/network-scripts/ifcfg-' + device)
	if os.path.exists('/etc/sysconfig/network-scripts/chat-' + device):
	    os.unlink('/etc/sysconfig/network-scripts/chat-' + device)
	if os.path.exists('/etc/sysconfig/network-scripts/dip-' + device):
	    os.unlink('/etc/sysconfig/network-scripts/dip-' + device)
	if self.cfgfiles.has_key('ifcfg-'+device):
	    del self.cfgfiles['ifcfg-'+device]
	self.IFBox.delete(index)
	# also need to remove from lists so that the names can be re-used
	for list in [self.G.devs, self.G.runningdevs, self.G.iflist, self.listdevs]:
	    for index in range(len(list)):
		# we need to compare against the length of the list every
		# time because it shrinks...
		if index < len(list) and not cmp(list[index], device):
		    list[index:index+1] = []
	# FIXME: delete aliases also, and warn user about it!
	# (Maybe that needs to be done at a higher level?)
	# FIXME: should we delete entries in /etc/pap-secrets?

    def __init__(self, Master, GV):
	self.G = GV
	SubFrame.__init__(self, Master)
	# standard abort strings
	self.AbortStrings=['BUSY', 'ERROR', 'NO CARRIER', 'NO DIALTONE', \
			   'Invalid Login', 'Login incorrect']

	self.IFBox = MultifieldListbox(self, [('Interface', 15, 0), ('IP', 20, 1),
 				      ('proto', 6, 1), ('atboot', 6, 0,),
				      ('active', 8, 0)])
	# Listing interfaces

	# First merge the self.G.iflist and self.G.devs lists into one list
	# of devices we are interested in at all.
	self.listdevs = self.G.iflist[0:]
	mergeLists(self.listdevs, self.G.devs)

	# Then choose whether or not they are editable:
	# If a device is available and running and no ifcfg-* file is available
	# for it, then it should be listed as an unmanaged device and is not
	# configurable with this system.  This does NOT apply to ppp devices.
	# All devices which have ifcfg-* files, or which are available and not
	# running, should be listed and may be edited.
	#
	# That can be restated as:
	# for all (available or ifcfg-*) devices
	#   if ifcfg-* file for device, then
	#     get device data from it, show it, and allow user to change
	#   else if running, then
	#          unmanaged; shown but no changes
	#        else (no ifcfg-*; not running) then
	#          managed; show blank data and allow changes
	self.cfgfiles = {}
	for iface in self.listdevs:
	    if iface in self.G.runningdevs:
		active = 'active'
	    else:
		active = 'inactive'
	    if iface in self.G.iflist:
		file = 'ifcfg-' + iface
		if string.find(iface, '-') == -1:
		    self.cfgfiles[file] = \
			ConfShellVar('/etc/sysconfig/network-scripts/' + file)
		else:
		    # clone device
		    cloned, clonename = tuple(string.split(iface, '-', 1))
		    if not self.cfgfiles.has_key('ifcfg-'+cloned):
			self.cfgfiles['ifcfg-'+cloned] = \
			  ConfShellVar('/etc/sysconfig/network-scripts/'+'ifcfg-'+cloned)
		    self.cfgfiles[file] = \
			ConfShellVarClone(self.cfgfiles['ifcfg-'+cloned],
			'/etc/sysconfig/network-scripts/'+file)

		cf = self.cfgfiles[file]
		if not cf['BOOTPROTO']:
		    cf.fsf()
		    cf['BOOTPROTO'] = 'none'
		self.IFBox.insert((iface,
				   cf['IPADDR'],
				   cf['BOOTPROTO'],
				   cf['ONBOOT'], active))
	    else:
		# no config script
		#  o if it is active, then it is brought up some other way
		#    and we shouldn't mess with it (unmanaged)
		#  o if it is inactive, then we allow people to edit it;
		#    they probably just added an ethernet card or something...
		if not cmp(active, 'active'):
		    self.IFBox.insert((iface, 'unmanaged device', '', '', active))
		else:
		    self.IFBox.insert((iface, '', 'none', '', active))
	self.IFBox.bind('<Double-Button-1>', self.editEntry)
	BB = ButtonBar(self)
	BB.setOrientation('horizontal')
	BB.addButton('Add', self.addEntry)
	BB.addButton('Edit', self.editEntry)
	BB.addButton('Clone', self.cloneEntry)
	BB.addButton('Alias', self.aliasEntry)
	BB.addButton('Remove', self.removeEntry)
	BB.addButton('Activate', self.activateEntry)
	BB.addButton('Deactivate', self.deactivateEntry)
	self.IFBox.pack({'side':'top', 'expand':'1', 'fill':'both'})
	BB.pack({'side':'bottom'})

    def save(self):
	for file in self.cfgfiles.keys():
	    self.cfgfiles[file].write()


class Routing(SubFrame):
    def edit(self, index = -1):
	self.saveindex = index
	self.T = Toplevel()
	self.T.title('Edit Static Route')
	self.dev = StringVar(self.T)
	self.net = StringVar(self.T)
	self.netmask = StringVar(self.T)
	self.gateway = StringVar(self.T)
	self.replace = 0
	self.deldev = 0
	if index >= 0:
	    self.replace = 1
	    item = self.RouteBox.getItems(index)
	    self.dev.set(item[0])
	    self.net.set(item[1])
	    self.netmask.set(item[2])
	    self.gateway.set(item[3])
	    self.deldev = item[0]
	    # turn tuple into list
	    self.delroute = [item[1], item[2], item[3]]
	F = RHFrame(self.T)
	LabelledEntry(F, 'Device:', self.dev, '15').pack(
	  {'side':'top', 'expand':'1', 'fill':'x'})
	LabelledEntry(F, 'Network:', self.net, '15').pack(
	  {'side':'top', 'expand':'1', 'fill':'x'})
	LabelledEntry(F, 'Netmask:', self.netmask, '15').pack(
	  {'side':'top', 'expand':'1', 'fill':'x'})
	LabelledEntry(F, 'Gateway:', self.gateway, '15').pack(
	  {'side':'top', 'expand':'1', 'fill':'x'})
	BB = ButtonBar(F)
	BB.setOrientation('horizontal')
	BB.addButton('Done', self.setEntry)
	BB.addButton('Cancel', self.T.destroy)
	BB.pack({'side':'bottom'})
	F.pack({'side':'top', 'expand':'1', 'fill':'both'})
	self.T.update()
	self.T.grab_set()
	self.T.wait_window(self.T)
	self.T.grab_release()
    def addEntry(self):
	self.edit()
    def editEntry(self):
	if not self.RouteBox.getSelectedItems():
	    return
	return self.edit(string.atoi(self.RouteBox.curselection()[0]))
    def setEntry(self):
	if self.deldev:
	    self.G.ESStaticRoutes.delroute(self.deldev, self.delroute)
	self.G.ESStaticRoutes.addroute(self.dev.get(), [self.net.get(),
					self.netmask.get(), self.gateway.get()])
	# Now, need to delete the whole listbox and start over, since
	# the changed route may actually duplicate an existing route
	# in the listbox.  Yuck.  That's what I get for having data
	# duplicated.  Should I implement callbacks?
	# For now, use this brute force hack, which works...
	self.RouteBox.delete(0, 'end')
	for device in self.G.ESStaticRoutes.keys():
	    for route in self.G.ESStaticRoutes[device]:
		self.RouteBox.insert((device, route[0], route[1], route[2]))
	self.RouteBox.selectLine(self.saveindex)
	self.T.destroy()
    def removeEntry(self):
	item = self.RouteBox.getSelectedItems()
	if not item:
	    return
	item = item[0]
	# turn tuple into list
	route = [item[1], item[2], item[3]]
	self.G.ESStaticRoutes.delroute(item[0], route)
	index = string.atoi(self.RouteBox.curselection()[0])
	self.RouteBox.delete(index)
	if self.RouteBox.getItems(index):
	    self.RouteBox.selectLine(index)
    def editOnclick(self, entry):
	return self.editEntry()

    def __init__(self, Master, GV):
	self.G = GV
	self.ipv4forward = IntVar(Master)
	if self.G.Networks['FORWARD_IPV4']:
	    self.ipv4forward.set(isyes(self.G.Networks['FORWARD_IPV4']))
	else:
	    self.ipv4forward.set(1)
	self.defgateway = StringVar(Master)
	self.defgateway.set(self.G.Networks['GATEWAY'])
	self.defgatewaydev = StringVar(Master)
	self.defgatewaydev.set(self.G.Networks['GATEWAYDEV'])
	SubFrame.__init__(self, Master)
	Checkbutton(self, {'text':'Network Packet Forwarding (IPv4)',
			     'variable':self.ipv4forward}).pack(
	  {'side':'top', 'anchor':'w'})
	LabelledEntry(self, 'Default Gateway:', self.defgateway, '22').pack(
	  {'side':'top', 'fill':'x'})
	LabelledEntry(self, 'Default Gateway Device:', self.defgatewaydev, '22').pack(
	  {'side':'top', 'fill':'x'})
	self.RouteBox = MultifieldListbox(self,
		[('Interface', 12, 0), ('Network Address', 15, 0),
		 ('Netmask', 15, 0), ('gateway', 15, 1)])
	self.RouteBox['height'] = 5
	for device in self.G.ESStaticRoutes.keys():
	    for route in self.G.ESStaticRoutes[device]:
		self.RouteBox.insert((device, route[0], route[1], route[2]))
	self.RouteBox.bind('<Double-Button-1>', self.editOnclick)
	BB = ButtonBar(self)
	BB.setOrientation('horizontal')
	BB.addButton('Add', self.addEntry)
	BB.addButton('Edit', self.editEntry)
	BB.addButton('Remove', self.removeEntry)
	BB.pack({'side':'bottom'})
	self.RouteBox.pack({'side':'top', 'expand':'1', 'fill':'both'})

    def save(self):
	self.G.Networks['GATEWAY'] = self.defgateway.get()
	self.G.Networks['GATEWAYDEV'] = self.defgatewaydev.get()
	self.G.Networks['FORWARD_IPV4'] = yn(self.ipv4forward.get())


class WindowFrame(RHFrame):
    def save(self):
	self.Names.save()
	self.Hosts.save()
	self.Interfaces.save()
	self.Routing.save()
	self.G.save()

    def showNames(self):
	self.currentframe.hide()
	self.currentframe = self.Names
	self.Names.show()

    def showHosts(self):
	self.currentframe.hide()
	self.currentframe = self.Hosts
	self.Hosts.show()

    def showInterfaces(self):
	self.currentframe.hide()
	self.currentframe = self.Interfaces
	self.Interfaces.show()

    def showRouting(self):
	self.currentframe.hide()
	self.currentframe = self.Routing
	self.Routing.show()

    def helpDisabled(self, event=None):
	Dialog('Error', 'Sorry; no help has been written yet. :-(',
	       'warning', 0, ['Ok']).num

    def __init__(self, Master = None):
	# I really don't like to do this, but there are serious
	# packing problems with resizing.  Anyone who wants to
	# resize this will have to either change it here or
	# really fix the packing throughout this whole app...
	Master.minsize(527, 375)
	Master.maxsize(527, 375)
	Master.geometry('527x375')
	Master.title('Network Configurator')
	# initialize "global" variables
	self.G = GV()
	RHFrame.__init__(self, Master)
	FR = Frame(self, {'relief':'groove', 'bd':'4'})
	self.Names = Names(FR, self.G)
	self.currentframe = self.Names
	self.Hosts = Hosts(FR, self.G)
	self.Interfaces = Interfaces(FR, self.G)
	self.Routing = Routing(FR, self.G)
	TFR = Frame(self)
	FT = FolderTabs(TFR)
	FT.addTab('Names', self.showNames, 1)
	FT.addTab('Hosts', self.showHosts)
	FT.addTab('Interfaces', self.showInterfaces)
	FT.addTab('Routing', self.showRouting)
	#Help = Button(TFR, {'text':'Help', 'command':self.helpDisabled})
	SM = ButtonBar(self)
	SM.setOrientation('horizontal')
	SM.addButton('Save', self.save)
	SM.addButton('Quit', self.quit)
	FT.pack({'side':'left', 'anchor':'nw'})
	#Help.pack({'side':'right', 'anchor':'ne'})
	TFR.pack({'side':'top', 'anchor':'nw', 'fill':'x'})
	self.Names.show()
	FR.pack({'side':'top', 'expand':'1', 'fill':'both'})
	SM.pack({'side':'top', 'fill':'x'})
	self.pack({'expand':'1', 'fill':'both'})

# magic to keep a root window from appearing
L = Label()
L.tk.call('wm', 'withdraw', '.')
del L

win = WindowFrame(Toplevel())

win.wait_window(win)

