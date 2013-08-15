use strict;

my $count = 0;
my $skip = 0;

while(<DATA>) {
    next if /^\s+/;
    
    if ($skip) {
       $skip=0;
       next;
    }
        
    $count++ if /^&#/;        
    $count++ if /^&\w/;
    # print "$count: ";             
    print;
    if($count == 2) {
       $count = 0;
       print "\n";
       $skip = 1;          
    }

    
}
# print $count, "\n";

__DATA__
"
&#34;
&quot;
quotation mark

'
&#39;
&apos; 
apostrophe 

&
&#38;
&amp;
ampersand

<
&#60;
&lt;
less-than

>
&#62;
&gt;
greater-than

¡
&#161;
&iexcl;
inverted exclamation mark

¢
&#162;
&cent;
cent

£
&#163;
&pound;
pound

¤
&#164;
&curren;
currency

¥
&#165;
&yen;
yen

¦
&#166;
&brvbar;
broken vertical bar

§
&#167;
&sect;
section

¨
&#168;
&uml;
spacing diaeresis

©
&#169;
&copy;
copyright

ª
&#170;
&ordf;
feminine ordinal indicator

«
&#171;
&laquo;
angle quotation mark (left)

¬
&#172;
&not;
negation
­
&#173;
&shy;
soft hyphen

®
&#174;
&reg;
registered trademark

¯
&#175;
&macr;
spacing macron

°
&#176;
&deg;
degree

±
&#177;
&plusmn;
plus-or-minus 

²
&#178;
&sup2;
superscript 2

³
&#179;
&sup3;
superscript 3

´
&#180;
&acute;
spacing acute

µ
&#181;
&micro;
micro

¶
&#182;
&para;
paragraph

·
&#183;
&middot;
middle dot

¸
&#184;
&cedil;
spacing cedilla

¹
&#185;
&sup1;
superscript 1

º
&#186;
&ordm;
masculine ordinal indicator

»
&#187;
&raquo;
angle quotation mark (right)

¼
&#188;
&frac14;
fraction 1/4

½
&#189;
&frac12;
fraction 1/2

¾
&#190;
&frac34;
fraction 3/4

¿
&#191;
&iquest;
inverted question mark

×
&#215;
&times;
multiplication

÷
&#247;
&divide;
division

&#8704;
&forall;
for all

∂
&#8706;
&part;
part

∏
&#8719;
&prod;
prod

∑
&#8721;
&sum;
sum

−
&#8722;
&minus;
minus

∞
&#8734;
&infin;
infinity

∩
&#8745;
&cap;
cap

∫
&#8747;
&int;
integral

≈
&#8776;
&asymp;
almost equal

≠
&#8800;
&ne;
not equal
≡
&#8801;
&equiv;
equivalent
≤
&#8804;
&le;
less or equal
≥
&#8805;
&ge;
greater or equal


Α
&#913;
&Alpha;
Alpha

Β
&#914;
&Beta;
Beta

Γ
&#915;
&Gamma;
Gamma

Δ
&#916;
&Delta;
Delta

Ε
&#917;
&Epsilon;
Epsilon

Ζ
&#918;
&Zeta;
Zeta

Η
&#919;
&Eta;
Eta

Θ
&#920;
&Theta;
Theta

Ι
&#921;
&Iota;
Iota

Κ
&#922;
&Kappa;
Kappa

Λ
&#923;
&Lambda;
Lambda

Μ
&#924;
&Mu;
Mu

Ν
&#925;
&Nu;
Nu

Ξ
&#926;
&Xi;
Xi

Ο
&#927;
&Omicron;
Omicron

Π
&#928;
&Pi;
Pi

Ρ
&#929;
&Rho;
Rho

Σ
&#931;
&Sigma;
Sigma

Τ
&#932;
&Tau;
Tau

Υ
&#933;
&Upsilon;
Upsilon

Φ
&#934;
&Phi;
Phi

Χ
&#935;
&Chi;
Chi

Ψ
&#936;
&Psi;
Psi

Ω
&#937;
&Omega;
Omega
 
α
&#945;
&alpha;
alpha

β
&#946;
&beta;
beta

γ
&#947;
&gamma;
gamma

δ
&#948;
&delta;
delta

ε
&#949;
&epsilon;
epsilon

ζ
&#950;
&zeta;
zeta

η
&#951;
&eta;
eta

θ
&#952;
&theta;
theta

ι
&#953;
&iota;
iota

κ
&#954;
&kappa;
kappa

λ
&#955;
&lambda;
lambda

μ
&#956;
&mu;
mu
ν
&#957;
&nu;
nu
ξ
&#958;
&xi;
xi
ο
&#959;
&omicron;
omicron
π
&#960;
&pi;
pi
ρ
&#961;
&rho;
rho
ς
&#962;
&sigmaf;
sigmaf
σ
&#963;
&sigma;
sigma
τ
&#964;
&tau;
tau
υ
&#965;
&upsilon;
upsilon
φ
&#966;
&phi;
phi
χ
&#967;
&chi;
chi
ψ
&#968;
&psi;
psi
ω
&#969;
&omega;
omega

Œ
&#338;
&OElig;
capital ligature OE
œ
&#339;
&oelig;
small ligature oe
Š
&#352;
&Scaron;
capital S with caron
š
&#353;
&scaron;
small S with caron
Ÿ
&#376;
&Yuml;
capital Y with diaeres
ƒ
&#402;
&fnof;
f with hook
ˆ
&#710;
&circ;
modifier letter circumflex accent
˜
&#732;
&tilde;
small tilde
‌
&#8204;
&zwnj;
zero width non-joiner
‍
&#8205;
&zwj;
zero width joiner
‎
&#8206;
&lrm;
left-to-right mark
‏
&#8207;
&rlm;
right-to-left mark

–
&#8211;
&ndash;
en dash

—
&#8212;
&mdash;
em dash

‘
&#8216;
&lsquo;
left single quotation mark

’
&#8217;
&rsquo;
right single quotation mark

‚
&#8218;
&sbquo;
single low-9 quotation mark

“
&#8220;
&ldquo;
left double quotation mark

”
&#8221;
&rdquo;
right double quotation mark

„
&#8222;
&bdquo;
double low-9 quotation mark

†
&#8224;
&dagger;
dagger

‡
&#8225;
&Dagger;
double dagger

•
&#8226;
&bull;
bullet

…
&#8230;
&hellip;
horizontal ellipsis

‰
&#8240;
&permil;
per mille 

′
&#8242;
&prime;
minutes

″
&#8243;
&Prime;
seconds

‹
&#8249;
&lsaquo;
single left angle quotation

›
&#8250;
&rsaquo;
single right angle quotation

‾
&#8254;
&oline;
overline

€
&#8364;
&euro;
euro

™
&#8482;
&trade;
trademark

←
&#8592;
&larr;
left arrow

↑
&#8593;
&uarr;
up arrow

→
&#8594;
&rarr;
right arrow

↓
&#8595;
&darr;
down arrow

↔
&#8596;
&harr;
left right arrow

◊
&#9674;
&loz;
lozenge

♠
&#9824;
&spades;
spade

♣
&#9827;
&clubs;
club

♥
&#9829;
&hearts;
heart

♦
&#9830;
&diams;
diamond


