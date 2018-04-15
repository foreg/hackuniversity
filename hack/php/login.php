<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <link href="../css/style.css" rel="stylesheet">
</head>
<body>
<div class="rightMenu ">
    <div class="korpus ">
        <input type="radio" name="odin" checked="checked" <? if (isset($_POST["in"])) echo 'checked="checked"';?> id="vkl1"/><label id="label1"  for="vkl1">Войти</label><input type="radio" name="odin" <? if (isset($_POST["up"])) echo 'checked="checked"';?> id="vkl2"/><label for="vkl2">Зарегистрироваться</label>
        <div><!--старый юзер-->
            <form class="vhod">
                <p class="small">Введите логин</p> 
                <input type="text" name="Email"             value="dmitrystrokov@mail.ru"                        placeholder="Логин"></input>
                <p class="small">Введите пароль</p> 
                <input type="password" name="Password"          value="Qwerty"                        placeholder="Пароль"></input>
                <input type="button" name="add" class="btn" value="Войти" onclick = "login(this)"></input>
            </form>
        </div>
        <div> <!--новый юзер-->
            <form class="register">
                <p class="small">E-mail</p>                 
                <input type="text" name="email"             value=""                        placeholder="e-mail"></input>
                <p class="small">Пароль (не менее 6 латинских символов разного регистра)</p> 
                <input type="password" name="PasswordN"          value=""                        placeholder="Пароль"></input>
                <p class="small">Подтвердите пароль</p> 
                <input type="password" name="Confirm"           value=""                        placeholder="Подтвердите"></input>
                <input type="button" name="add" class="btn" value="Зарегистрироваться" onclick = "newUser(this)"></input>
            </form>
        </div>
    </div>
</div>
<?
    
?>


<script>
    
// instantLogin();
// function instantLogin() {
//     var xmlhttp = new XMLHttpRequest();
//     xmlhttp.onreadystatechange = function() {
//         if (this.DONE == this.readyState) {
//             if(this.responseText == "") {
//                 //alert("Такая связка логин-пароль не найдена");
//             }
//             else {
//                 //alert("Добро пожаловать " + this.responseText);
//                 setCookie("username",document.getElementsByName('Email')[0].value,365);
//                 window.location = "https://127.0.0.1/_lab4/cart.html";
//             }
//         }
    
//     };
//     xmlhttp.open("POST",'/_lab4/submit.php' , true);
//     xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
//     xmlhttp.send();
// }
function login() {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.DONE == this.readyState) {
            if(this.responseText == "") {
                alert("Такая связка логин-пароль не найдена");
            }
            else {
                //alert("Добро пожаловать " + this.responseText);
                setCookie("username",md5(document.getElementsByName('Email')[0].value+document.getElementsByName('Password')[0].value ),365);
                window.location = "https://127.0.0.1/hack/php/profile.php";
            }
        }
    
    };
    var body =  'Type=login' + 
                '&Email=' + document.getElementsByName('Email')[0].value + 
                '&Password='+ document.getElementsByName('Password')[0].value;
    xmlhttp.open("POST",'/hack/php/submit.php' , true);
    xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xmlhttp.send(body); 
}
function newUser(t) {
var regForEmail = /^[A-Za-z0-9]{1,}@\w{2,6}.\w{2,3}$/;

    if (regForEmail.test(document.getElementsByName('email')[0].value)) {
        if (document.getElementsByName('PasswordN')[0].value == document.getElementsByName('Confirm')[0].value) {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
            if (this.DONE == this.readyState){
                    if(this.responseText == "") {
                        alert("Пользователь успешно зарегистрирован. Войдите с аккаунт");
                        //alert(this.responseText.indexOf("Пользователь"+" с таким логином уже есть"));
                        location.reload();  
                    }
                    else {
                        alert(this.responseText);
                    }
                }
            };
            var body = 'Type=register' + 
            '&Email=' + document.getElementsByName('email')[0].value + 
            '&Password='+ document.getElementsByName('PasswordN')[0].value;
            xmlhttp.open("POST",'/hack/php/submit.php' , true);
            xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xmlhttp.send(body);
        }
        else {
            alert("Пароли должны совпадать");
        }
    }
    else {
        alert("Введен неправильный e-mail");                
    }
}

function setCookie(c_name,value,exdays) {
        var exdate=new Date();
        exdate.setDate(exdate.getDate() + exdays);
        var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
        document.cookie=c_name + "=" + c_value;
    }
function getCookie(c_name){
    var i,x,y,ARRcookies=document.cookie.split(";");
    for (i=0;i<ARRcookies.length;i++) {
        x=ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
        y=ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);
        x=x.replace(/^\s+|\s+$/g,"");
        if (x==c_name) {
            return unescape(y);
        }
    }
}
function checkCookie() {
    var username=getCookie("username");
    if (username!=null && username!="") {
        return true
    }
    else {
        return false;
    }
}
function utf8_encode ( str_data ) {	// Encodes an ISO-8859-1 string to UTF-8
	// 
	// +   original by: Webtoolkit.info (http://www.webtoolkit.info/)

	str_data = str_data.replace(/\r\n/g,"\n");
	var utftext = "";

	for (var n = 0; n < str_data.length; n++) {
		var c = str_data.charCodeAt(n);
		if (c < 128) {
			utftext += String.fromCharCode(c);
		} else if((c > 127) && (c < 2048)) {
			utftext += String.fromCharCode((c >> 6) | 192);
			utftext += String.fromCharCode((c & 63) | 128);
		} else {
			utftext += String.fromCharCode((c >> 12) | 224);
			utftext += String.fromCharCode(((c >> 6) & 63) | 128);
			utftext += String.fromCharCode((c & 63) | 128);
		}
	}

	return utftext;
}

function md5 ( str ) {	// Calculate the md5 hash of a string
	// 
	// +   original by: Webtoolkit.info (http://www.webtoolkit.info/)
	// + namespaced by: Michael White (http://crestidg.com)

	var RotateLeft = function(lValue, iShiftBits) {
			return (lValue<<iShiftBits) | (lValue>>>(32-iShiftBits));
		};

	var AddUnsigned = function(lX,lY) {
			var lX4,lY4,lX8,lY8,lResult;
			lX8 = (lX & 0x80000000);
			lY8 = (lY & 0x80000000);
			lX4 = (lX & 0x40000000);
			lY4 = (lY & 0x40000000);
			lResult = (lX & 0x3FFFFFFF)+(lY & 0x3FFFFFFF);
			if (lX4 & lY4) {
				return (lResult ^ 0x80000000 ^ lX8 ^ lY8);
			}
			if (lX4 | lY4) {
				if (lResult & 0x40000000) {
					return (lResult ^ 0xC0000000 ^ lX8 ^ lY8);
				} else {
					return (lResult ^ 0x40000000 ^ lX8 ^ lY8);
				}
			} else {
				return (lResult ^ lX8 ^ lY8);
			}
		};

	var F = function(x,y,z) { return (x & y) | ((~x) & z); };
	var G = function(x,y,z) { return (x & z) | (y & (~z)); };
	var H = function(x,y,z) { return (x ^ y ^ z); };
	var I = function(x,y,z) { return (y ^ (x | (~z))); };

	var FF = function(a,b,c,d,x,s,ac) {
			a = AddUnsigned(a, AddUnsigned(AddUnsigned(F(b, c, d), x), ac));
			return AddUnsigned(RotateLeft(a, s), b);
		};

	var GG = function(a,b,c,d,x,s,ac) {
			a = AddUnsigned(a, AddUnsigned(AddUnsigned(G(b, c, d), x), ac));
			return AddUnsigned(RotateLeft(a, s), b);
		};

	var HH = function(a,b,c,d,x,s,ac) {
			a = AddUnsigned(a, AddUnsigned(AddUnsigned(H(b, c, d), x), ac));
			return AddUnsigned(RotateLeft(a, s), b);
		};

	var II = function(a,b,c,d,x,s,ac) {
			a = AddUnsigned(a, AddUnsigned(AddUnsigned(I(b, c, d), x), ac));
			return AddUnsigned(RotateLeft(a, s), b);
		};

	var ConvertToWordArray = function(str) {
			var lWordCount;
			var lMessageLength = str.length;
			var lNumberOfWords_temp1=lMessageLength + 8;
			var lNumberOfWords_temp2=(lNumberOfWords_temp1-(lNumberOfWords_temp1 % 64))/64;
			var lNumberOfWords = (lNumberOfWords_temp2+1)*16;
			var lWordArray=Array(lNumberOfWords-1);
			var lBytePosition = 0;
			var lByteCount = 0;
			while ( lByteCount < lMessageLength ) {
				lWordCount = (lByteCount-(lByteCount % 4))/4;
				lBytePosition = (lByteCount % 4)*8;
				lWordArray[lWordCount] = (lWordArray[lWordCount] | (str.charCodeAt(lByteCount)<<lBytePosition));
				lByteCount++;
			}
			lWordCount = (lByteCount-(lByteCount % 4))/4;
			lBytePosition = (lByteCount % 4)*8;
			lWordArray[lWordCount] = lWordArray[lWordCount] | (0x80<<lBytePosition);
			lWordArray[lNumberOfWords-2] = lMessageLength<<3;
			lWordArray[lNumberOfWords-1] = lMessageLength>>>29;
			return lWordArray;
		};

	var WordToHex = function(lValue) {
			var WordToHexValue="",WordToHexValue_temp="",lByte,lCount;
			for (lCount = 0;lCount<=3;lCount++) {
				lByte = (lValue>>>(lCount*8)) & 255;
				WordToHexValue_temp = "0" + lByte.toString(16);
				WordToHexValue = WordToHexValue + WordToHexValue_temp.substr(WordToHexValue_temp.length-2,2);
			}
			return WordToHexValue;
		};

	var x=Array();
	var k,AA,BB,CC,DD,a,b,c,d;
	var S11=7, S12=12, S13=17, S14=22;
	var S21=5, S22=9 , S23=14, S24=20;
	var S31=4, S32=11, S33=16, S34=23;
	var S41=6, S42=10, S43=15, S44=21;

	str = this.utf8_encode(str);
	x = ConvertToWordArray(str);
	a = 0x67452301; b = 0xEFCDAB89; c = 0x98BADCFE; d = 0x10325476;

	for (k=0;k<x.length;k+=16) {
		AA=a; BB=b; CC=c; DD=d;
		a=FF(a,b,c,d,x[k+0], S11,0xD76AA478);
		d=FF(d,a,b,c,x[k+1], S12,0xE8C7B756);
		c=FF(c,d,a,b,x[k+2], S13,0x242070DB);
		b=FF(b,c,d,a,x[k+3], S14,0xC1BDCEEE);
		a=FF(a,b,c,d,x[k+4], S11,0xF57C0FAF);
		d=FF(d,a,b,c,x[k+5], S12,0x4787C62A);
		c=FF(c,d,a,b,x[k+6], S13,0xA8304613);
		b=FF(b,c,d,a,x[k+7], S14,0xFD469501);
		a=FF(a,b,c,d,x[k+8], S11,0x698098D8);
		d=FF(d,a,b,c,x[k+9], S12,0x8B44F7AF);
		c=FF(c,d,a,b,x[k+10],S13,0xFFFF5BB1);
		b=FF(b,c,d,a,x[k+11],S14,0x895CD7BE);
		a=FF(a,b,c,d,x[k+12],S11,0x6B901122);
		d=FF(d,a,b,c,x[k+13],S12,0xFD987193);
		c=FF(c,d,a,b,x[k+14],S13,0xA679438E);
		b=FF(b,c,d,a,x[k+15],S14,0x49B40821);
		a=GG(a,b,c,d,x[k+1], S21,0xF61E2562);
		d=GG(d,a,b,c,x[k+6], S22,0xC040B340);
		c=GG(c,d,a,b,x[k+11],S23,0x265E5A51);
		b=GG(b,c,d,a,x[k+0], S24,0xE9B6C7AA);
		a=GG(a,b,c,d,x[k+5], S21,0xD62F105D);
		d=GG(d,a,b,c,x[k+10],S22,0x2441453);
		c=GG(c,d,a,b,x[k+15],S23,0xD8A1E681);
		b=GG(b,c,d,a,x[k+4], S24,0xE7D3FBC8);
		a=GG(a,b,c,d,x[k+9], S21,0x21E1CDE6);
		d=GG(d,a,b,c,x[k+14],S22,0xC33707D6);
		c=GG(c,d,a,b,x[k+3], S23,0xF4D50D87);
		b=GG(b,c,d,a,x[k+8], S24,0x455A14ED);
		a=GG(a,b,c,d,x[k+13],S21,0xA9E3E905);
		d=GG(d,a,b,c,x[k+2], S22,0xFCEFA3F8);
		c=GG(c,d,a,b,x[k+7], S23,0x676F02D9);
		b=GG(b,c,d,a,x[k+12],S24,0x8D2A4C8A);
		a=HH(a,b,c,d,x[k+5], S31,0xFFFA3942);
		d=HH(d,a,b,c,x[k+8], S32,0x8771F681);
		c=HH(c,d,a,b,x[k+11],S33,0x6D9D6122);
		b=HH(b,c,d,a,x[k+14],S34,0xFDE5380C);
		a=HH(a,b,c,d,x[k+1], S31,0xA4BEEA44);
		d=HH(d,a,b,c,x[k+4], S32,0x4BDECFA9);
		c=HH(c,d,a,b,x[k+7], S33,0xF6BB4B60);
		b=HH(b,c,d,a,x[k+10],S34,0xBEBFBC70);
		a=HH(a,b,c,d,x[k+13],S31,0x289B7EC6);
		d=HH(d,a,b,c,x[k+0], S32,0xEAA127FA);
		c=HH(c,d,a,b,x[k+3], S33,0xD4EF3085);
		b=HH(b,c,d,a,x[k+6], S34,0x4881D05);
		a=HH(a,b,c,d,x[k+9], S31,0xD9D4D039);
		d=HH(d,a,b,c,x[k+12],S32,0xE6DB99E5);
		c=HH(c,d,a,b,x[k+15],S33,0x1FA27CF8);
		b=HH(b,c,d,a,x[k+2], S34,0xC4AC5665);
		a=II(a,b,c,d,x[k+0], S41,0xF4292244);
		d=II(d,a,b,c,x[k+7], S42,0x432AFF97);
		c=II(c,d,a,b,x[k+14],S43,0xAB9423A7);
		b=II(b,c,d,a,x[k+5], S44,0xFC93A039);
		a=II(a,b,c,d,x[k+12],S41,0x655B59C3);
		d=II(d,a,b,c,x[k+3], S42,0x8F0CCC92);
		c=II(c,d,a,b,x[k+10],S43,0xFFEFF47D);
		b=II(b,c,d,a,x[k+1], S44,0x85845DD1);
		a=II(a,b,c,d,x[k+8], S41,0x6FA87E4F);
		d=II(d,a,b,c,x[k+15],S42,0xFE2CE6E0);
		c=II(c,d,a,b,x[k+6], S43,0xA3014314);
		b=II(b,c,d,a,x[k+13],S44,0x4E0811A1);
		a=II(a,b,c,d,x[k+4], S41,0xF7537E82);
		d=II(d,a,b,c,x[k+11],S42,0xBD3AF235);
		c=II(c,d,a,b,x[k+2], S43,0x2AD7D2BB);
		b=II(b,c,d,a,x[k+9], S44,0xEB86D391);
		a=AddUnsigned(a,AA);
		b=AddUnsigned(b,BB);
		c=AddUnsigned(c,CC);
		d=AddUnsigned(d,DD);
	}

	var temp = WordToHex(a)+WordToHex(b)+WordToHex(c)+WordToHex(d);

	return temp.toLowerCase();
}

</script>
</body>
</html>