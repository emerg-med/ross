#!/usr/bin/perl 


open (OUT,">junk.txt");
print OUT "hello";
close (OUT);

#### process using lout

exec ("lout temp/notes.txt >temp/notes.ps");

#### send it to the printer




die "it hasn't worked";

exit;