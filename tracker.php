http://amzn.to/11o12YH
current running version (beta 1.7).

FTP username: vitumob@ecosandals.com
FTP password: the-devs
FTP server: ftp.ecosandals.com
FTP & explicit FTPS port: 21

2. Setting up the e-commerce account at I&M Bank.
3. help get devs registered

1. Customer places order online and elects to pay with MPesa.
2. Customer takes out phone and sends MPesa to our Paybill number.
3. Safaricom activates IPN and sends parameters to https://www.vitumob.com/mpesa
4. Server-side script receives IPN communication and sends OK back to Safaricom (2.2, page 5)
5. Server-side script 
	(i) updates our database to show customer order as fully paid; 
	(ii) updates our database to show customer order as partially paid; or 
	(iii) there is a mismatch and Muchiri/Matt are notified.
6. Email/SMS is sent to customer congratulating them on their order. 


https://yourip/yourscript.php
?id=2970
&orig=MPESA
&dest=254700733153
&tstamp=2011-07-06+22%3A48%3A56.0
&text=BM46ST941+Confirmed.+%0Aon+6%2F7%2F11+at+10%3A49+PM+%0AKsh8%2C723.00+received+from+RONALD+NDALO+254722291067.+%0AAccount+Number+5FML59-01+%0ANew+Utility+balance+is+Ksh6%2C375%2C223.00
&customer_id=2
&user=123
&pass=123
&routemethod_id=2
&routemethod_name=HTTP
&mpesa_code=BM46ST941
&mpesa_acc=5FML59-01
&mpesa_msisdn=254722291067
&mpesa_trx_date=6%2F7%2F11
&mpesa_trx_time=10%3A49+PM
&mpesa_amt=8723.0
&mpesa_sender=RONALD+NDALO

https://yourip/yourscript.php
?id=2970
&orig=MPESA
&dest=254700733153
&tstamp=2011-07-06 22:48:56.0
&text=BM46ST941 Confirmed.on 6/7/11 at 10:49 PM Ksh8,723.00 received from RONALD NDALO 254722291067.Account Number 5FML59-01 New Utility balance is Ksh6,375,223.00
&customer_id=2
&user=123
&pass=123
&routemethod_id=2
&routemethod_name=HTTP
&mpesa_code=BM46ST941
&mpesa_acc=5FML59-01
&mpesa_msisdn=254722291067
&mpesa_trx_date=6/7/11
&mpesa_trx_time=10:49 PM
&mpesa_amt=8723.0
&mpesa_sender=RONALD NDALO

https://yourip/yourscript.php?
id=2970&
orig=MPESA&
dest=254700733153&
tstamp=2011-07-06 22:48:56.0&
text=BM46ST941 Confirmed.on 6/7/11 ...New balance is Ksh6,375,223.00&
customer_id=2&
user=123&
pass=123&
routemethod_id=2&
routemethod_name=HTTP&
mpesa_code=BM46ST941&
mpesa_acc=5FML59-01&
mpesa_msisdn=254722291067&
mpesa_trx_date=6/7/11&
mpesa_trx_time=10:49 PM&
mpesa_amt=8723.0&
mpesa_sender=RONALD NDALO





%SYSTEMROOT%\SYSTEM32;
%SYSTEMROOT%;
%SYSTEMROOT%\SYSTEM32\WBEM;
%SYSTEMROOT%\SYSTEM32\WINDOWSPOWERSHELL\V1.0\;
C:\PROGRAM FILES\BROADCOM\BROADCOM 802.11 NETWORK ADAPTER\DRIVER;
C:\PROGRAM FILES\GTKSHARP\2.12\BIN;
C:\PROGRAM FILES\COMMON FILES\ULEAD SYSTEMS\MPEG;
C:\PROGRAM FILES\ANDROID\ANDROID-SDK\TOOLS;
C:\PROGRAM FILES\ANDROID\ANDROID-SDK\PLATFORM-TOOLS;
C:\PROGRAM FILES\APACHE-ANT-1.8.2\BIN;
C:\PROGRAM FILES\APACHE-ANT-1.8.2\BIN;
C:\XAMPP\PHP\;
C:\PROGRAMDATA\COMPOSER\BIN;
C:\PROGRAM FILES\TORTOISESVN\BIN;
C:\Program Files\WIDCOMM\Bluetooth Software\;
%AWS_RDS_HOME%\bin


http://amzn.to/11o12YH
User Name: TheDevs
pwd: techy1Timo
AWS Access Key Id:  AKIAJDLFVCVZSAHFC5YQ
AWS Secret Key Id :  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

ec2-54-213-60-222.us-west-2.compute.amazonaws.com


mysql -h vitumob-instance.cskqeiwdvosu.us-west-2.rds.amazonaws.com -P 3306 -u vitumob -pvitu_mob#123
mysql -h aa9tn859jlrhr8.cskqeiwdvosu.us-west-2.rds.amazonaws.com -P 3306 -u vitumob -pvitu_mob#123
mysql source C:\Users\guru\Downloads\vitumob-latest.sql;

mysql -h vitumob-instance.cskqeiwdvosu.us-west-2.rds.amazonaws.com -P 3306 -u vitumob -pvitu_mob#123 vitumob 

mysql -u vitumob -pvitu_mob#123 --database=vitumob  -e "select * FROM cart" > cart.csv

-e "select * from cart"  | sed 's/\t/","/g;s/^/"/;s/$/"/;s/\n//g' > timfile.csv

SELECT * INTO OUTFILE '/tmp/vitumob.csv' FIELDS TERMINATED BY ',' ENCLOSED BY '"' ESCAPED BY '\\' LINES TERMINATED BY '\n' FROM vitumob

mysqldump -h vitumob-instance.cskqeiwdvosu.us-west-2.rds.amazonaws.com -P 3306 -u vitumob -pvitu_mob#123 vitumob > C:\Users\guru\Downloads\bp.sql

mysql -h new-vitumob.cskqeiwdvosu.us-west-2.rds.amazonaws.com -P 3306 -u vitumob -pvitu_mob#123

mysql -h timtestinstance.cr3nil4f6zic.us-east-1.rds.amazonaws.com -P 3306 -u tim -ptim

mysql -h tim-rds.cskqeiwdvosu.us-west-2.rds.amazonaws.com -P 3306 -u vitumob -pvitu_mob#123

mysqldump -h tim-rds.cskqeiwdvosu.us-west-2.rds.amazonaws.com -P 3306 -u vitumob -pvitu_mob#123 vitumob > C:\Users\guru\Downloads\backup.sql

# mysqldump -h localhost -u root -p bookcheetah_demo > C:\Users\guru\Downloads\backup.sql

mysqldump signs -h signs.c3x4aregvxxx.us-east-1.rds.amazonaws.com -P 3306 -u cartersxxx -pxxxxxx | mysql -u root -pxxxxxx signs

Creating a db instance:
-----------------------
rds-create-db-instance --engine MySQL5.1 --master-username tim --master-user-password tim --db-name timtest --db-instance-identifier timtestinstance --allocated-storage 5 --db-instance-class db.t1.micro –-header
http://blog.webyog.com/2009/11/06/amazon-rds-the-beginners-guide/  

C:\Program Files\Java\jdk1.6.0_21


C:\Windows\System32>ec2-add-keypair pstam-keypair
KEYPAIR pstam-keypair   66:69:99:47:08:d9:73:96:2d:b0:79:be:3a:52:a4:36:20:61:b9:6b
-----BEGIN RSA PRIVATE KEY-----
MIIEpQIBAAKCAQEAjM5eDR8vvvpwkz8b+p+HjqeA2NlNquObGPLCbsfLYhDUIDMfGxF3mcbZO9jr
645DARgZTki3sF77gSQBwAuxk6B6d+FY7oJqddle+wnl5a4N+m0b9/xuvM14w2AIJ2d12klUJ63s
DAs0qmeecudxTtTvDjvN8ZJYCAwaJEeZ/zSLL3wY9X4SRMtqW/ncM4yJDGvLqnSmTrXzlBSfgB3y
fk7NYQ6un26ryZa/Ao6GTcenLd/S5mBdOD1M63vwB8r8T02gDBU84spDHm+ZdSOXR0qbn5G1Izak
vA/rwF8xz085t3vLF3GCMqcdEBXds26YrI9sU64RwMmFfLFfpn5NcwIDAQABAoIBAQCHchQixzck
nMAhxHljkoXRget9rTr7Acq2Kv9BlUtdYBbNip+HaDwGXrOk0DvQ8Z4etVHSbjzUmemRBlPwqs78
1Ug5fToQ5L8H8jtdfN37HH0xwjc/S0Iyt+xM9FmjnfBONG+RY8pGo5jbuqU+nsfuLwJuTLUEhePM
ieezsnS+ehGNiMYve2aTkRxUu+0pOAHzD1o5zWVDsNmZ9DIY7DzoXVdol6CZzAM7LJtloqNbgLYx
omPcvULqVaUttyxlO3Z3g/qhR52ikK+tA0L3XAdspm6FKMj/ZJb2QDESx5BjheMlDxhwMlMhhB1m
exhYMoWTLhQYchL3OXXhIDMQUZIxAoGBAPUn1DXKY+v+UTKgoKQCRfhWZnjlEmhMTP/hrcQ4kZeq
hIrLK7eOJfVb3DOOM86tRWPGMTWBO1eGHrXbwY68gFQ30C0vjLy8fEHzOGzaUUfrEviRaMntG7hM
+UZev3U8XXgGq0M7q/SU+TM61HkZh3N4o7aZ9ATIBMDjFtFDd3tlAoGBAJMI32pqc7rtt9H6MTJj
l5blM6r7mtp1e+kaZCTMrPjBxG4DBSCxYc3YrqsvO0ZQdEmNN7V+zeETx3KXDmvuhP68n8UUQRmj
cMe30glSeHU4YJ8qr4RVrvp027PRSv/hk4cGVW8hlOQ3hWx1O2uWrumZjjN4OcGyHgs9MjnKWtP3
AoGBAOm2dLprHeNHagVH2J1ChY4AYGR0jZ3cz7NJZK0h+LqMFxtyIVU2ML2+OyjzMjSgPvylXxhR
AU+pTvG0dMwsrHKdWtsY76SmVBdTVcGAR+i2FDnf9fQ7FSgYSbRqcz/CsqDQSsknxADBXOkX9qMU
UWsl4X0dO+KrBM0WMRSCqw95AoGAbLlZ42m2DBquG6HC8Ty9okH3085bMoE/UB5IwQFsQkGeC69G
AmfIJ5u7hS/Wx+bEJoM7F4UdnfqvN+fFLUBhrbAzAFs6zEeUJMqjkGsgUaWPpQK+aL+nNOJmd3Ai
4lWebnDbieKuI5d+nLWPa74vtuLqSNr08mrQVoU494zPXv8CgYEAuOLtBE5mSv91hLqSr2TBFkDu
gS6jWIAj0pEy0Xh52h8hBeOMV2Vh2tfMq8AIJh69uVge4yM2ZBrLFhtI7DyTLEujZEw1xhHYytf5
oxD1m2IRAY2PwPF4xE/oFvAPRKDe0hJpdUkCIDRiyCieC+VF5oNM/prradLkfAAloodj89pTXP_n
oxD1m2IRAY2PwPF4xE/oFvAPRKDe0hJpdUkCIDRiyCieC+VF5oNM/prradLkfAAd4XyzKiM=
-----END RSA PRIVATE KEY-----

105.165.127.99
Your public IP address is 105.162.12.6 

All of the AMIs you have access to, and there are a lot. 
ec2-describe-images -a

Alternatively you can list just the images Amazon has:
ec2-describe-images -o amazon

vitumob AMI: amzn-ami-pv-2012.09.0.i386-ebs (ami-2231bf12)
Zone: us-west-2b	Security Groups: awseb-e-uii82bmwmi-stack-AWSEBSecurityGroup-11UBEQ2EG9GEF

rds-create-db-instance --engine MySQL5.1 --db-name timtest --db-instance-identifier timtestinstance --allocated-storage 5 --db-instance-class db.m1.xlarge –-header

contact@vitumob.com









SQLSTATE[42S22]: Column not found: 1054 Unknown column '0' in 'field list' (
SQL: insert into `items` (`0`, `1`, `2`, `3`, `4`, `5`, `6`, `7`)
 values 
 (?, ?, ?, ?, ?, ?, ?, ?), 
 (?, ?, ?, ?, ?, ?, ?, ?), 
 (?, ?, ?, ?, ?, ?, ?, ?), 
 (?, ?, ?, ?, ?, ?, ?, ?)) 
 (
 Bindings: array ( 
		0 => array ( 
			0 => array ( 
				'id' => 'B006T7QWGO', 
				'quantity' => 1, 
				'price' => 143.79, 
				'creator' => 'FUJIFILM', 
				'id2' => 'CG52FKDKBWTHO', ),
			 1 => array ( 'id' => 'B001SIUPU8', 
				'quantity' => 1, 
				'price' => 31.27, 
				'creator' => 'Saga Musical Instruments', 
				'id2' => 'C3RMREQMJZPAJJ', ),
			),
		1 => 'amazon.com',
		2 => '2013-08-21 01:20:00',
		3 => '2013-08-21 01:20:00', 
	)
) 

$input = Input::all();
 SQLSTATE[42S22]: Column not found: 1054 Unknown column 'bundle' in 'field list' (
 SQL: insert into `items` (`bundle`, `extension`, `updated_at`, `created_at`)
  values (?, ?, ?, ?)) (
  	Bindings: array ( 

  		0 => '{
		  		"items":[

				  		{
					  		"id":"B006T7QWGO",
					  		"quantity":1,"price":141.38,"image":"http://ecx.images-amazon.com/images/_.jpg",
					  		"name":"Fujifilm FinePix S4200 Digital Camera",
					  		"link":"http://www.amazon.com/gp/produ=A1ONXNZCOVO2I6",
					  		"creator":"FUJIFILM",
					  		"id2":"CG52FKDKBWTHO"
					  	},

				  		{
					  		"id":"B00B7N9CWG",
					  		"quantity":1,"price":196.5,"image":"http://ecx.images-amazon.com/images/_.jpg",
					  		"name":"Nikon COOLPIX L820 16 MP CMOS Digital Camera",
					  		"link":"http://www.amazon.com/gp/produsc=1&smid=ATVPDKIKX0DER",
					  		"creator":"NIKON",
					  		"id2":"CRDJZW0B74NDJ"
					  	}
					],
		  		"host":"amazon.com"
			}', 

  		1 => 'firefox 0.9', 
  		2 => '2013-08-21 04:02:46', 
  		3 => '2013-08-21 04:02:46', 
  		)
  	)


//better quantity box

<td class="dta-qty">
	<input type="text" id="qty29510680" name="qty29510680" maxlength="2" value="5" onkeypress="if(event.keyCode==13) { if ( $(this).val() == 0 ) { if(confirm('Setting the Qty to zero will remove this item. Click OK to continue.')) { recalculate(document.formbasket, 'qty29510680'); } else { return false; } } else { recalculate(document.formbasket, 'qty29510680'); } } else { Is_Numeric('qty29510680'); }">
	<a href="javascript:recalculate(document.formbasket, 'qty29510680')" onclick="if(document.formbasket.qty29510680.value == 0) { return confirm('Setting the Qty to zero will remove this item. Click OK to continue.'); }">Update</a>
	<a href="javascript:remove(document.formbasket, '29510680')" onclick="return confirm('Delete this product?');" class="rmv">Remove</a>
</td>

//macy's json
	[14:05:22.359] "{
		"items":[
					{
						"image":"http://slimages",
						"name":"CHAN",
						"link":"http://www1.macys.com/shop/prod",
						"quantity":4,
						"price":65
					},
					{
						"image":"http://slimages",
						"name":"Receive a FREE DOWNTOWN Calvin Klein f",
						"link":"http://www1.macys.com/IFTID...",
						"color":"No Color",
						"id":"983353",
						"quantity":1,
						"price":2
					}
			],
		"host":"macys.com"
	}"


//macy's json

{"items":[

{

	"image":"http://slimages.macys.com/is/image/MCY/prot=jpeg",
	"name":"Polo Ralph Lauren Shoes, Faxon Canvas Lace Sneakers",
	"link":"http://www1.macy78&upc_ID=301BAG",
	"color":"Navy",
	"size":"7",
	"id":"652378",
	"quantity":3,
	"price":59
},

		//shoes...
{

	"image":"http://slimages.macjpeg",
	"name":"The North Face Sneakers, Hedgehog Guide GTX GORE-TEX Waterproof Sneakers",
	"link":"http://www1.macys.com/shop/prodEAG",
	"color":"Taupe /Green",
	"size":"9",
	"id":"766112",
	"quantity":3,
	"price":null
}

],"host":"macys.com"}




//amazon's json

{
	"items":[
{
	"id":"B003VNKNEQ",
	"quantity":1,
	"price":12.98,
	"image":"http://ecx.images-amazon.co",
	"name":"Transcend 16GB Class 10 SDHC Flash Memory Card (TS16GSDHC10E)",
	"link":"http://www.amazon.com/gp/pre=UTF8&psc=1&smid=ATVPDKIKX0DER",
	"creator":"TRANSCEND",
	"id2":"CB0FPN5J5DJ0K"

}],"host":"amazon.com"}

//cellhut json:

	[15:19:05.483] "{
		"items":
			[{
				"image":"http://www.cellhut.com/images/p_33621_S.jpg",
				"name":"Samsung I9500 Galaxy S4 (IV) White (Unlocked Quadband) GSM Cell Phone",
				"link":"http://www.cellhut.com/Samsung-I9500-Galaxy-S4-IV-621.html",
				"id":"33621",
				"quantity":1,
				"price":699.99
			}],
		"host":"cellhut.com"
	}"


//items form create/update post

Array ( 
	[_token] => 1FvwvtR99mgaw581pbzdWYzvwOGDMa2oOAy2eZ00 
	[session_id] => Sessionqwertyusid 
	[ip_address] => Ip_address:1234 
	[merchant_id] => Merchant_id:qwerty 
	[item_id] => Item_id2tyuio 
	[name] => namedfghj 
	[quantity] => 
	[link] => 
	[image] => 
	[designer] => 
	[color] => 
	[size] => 
	[package] => 
	[print_on_demand] => 
	[front_logo] => 
	[custom_back_number] => 
	[custom_back_name] => 
	[price_usd] => 
	[price_ksh] => 
) 
 
 	Array ( 
 	[items] =>	 Array ( 
		 	[0] => 	Array ( [id] => B006T7QWGO [quantity] => 1 [price] => 141.38 [image] => http://ecx.images-amazon.com/images/I/51lRCYDCtGL._SL500_SS100_.jpg [name] => Fujifilm FinePix S4200 Digital Camera [link] => http://www.amazon.com/gp/product/B006T7QWGO/ref=ox_sc_act_title_1?ie=UTF8&psc=1&smid=A1ONXNZCOVO2I6 [creator] => FUJIFILM [id2] => CG52FKDKBWTHO ) 

		 	[1] => 	Array ( [id] => B001SIUPU8 [quantity] => 1 [price] => 31.27 [image] => http://ecx.images-amazon.com/images/I/31Ce3uq1DbL._SL500_SS100_.jpg [name] => Mahalo U-30BU Painted Economy Soprano Ukulele (Blue) [link] => http://www.amazon.com/gp/product/B001SIUPU8/ref=ox_sc_act_title_2?ie=UTF8&psc=1&smid=ATVPDKIKX0DER [creator] => Saga Musical Instruments [id2] => C3RMREQMJZPAJJ ) 
	 	)
	[host] => amazon.com 
	) 

	SQLSTATE[42S22]: Column not found: 1054 Unknown column 'price' in 'field list' (
	SQL: insert into `items` 
	(`id`, `quantity`, `price`, `image`, `name`, `link`, `creator`, `id2`, `updated_at`, `created_at`)
	 values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)) 
	 (
	 Bindings: array ( 
		 0 => 'B006T7QWGO', 
		 1 => 1, 
		 2 => 141.38, 
		 3 => 'http://ecx.images-amazon.com/images/I/51lRCYDCtGL._SL500_SS100_.jpg', 
		 4 => 'Fujifilm FinePix S4200 Digital Camera', 
		 5 => 'http://www.amazon.com/gp/product/B006T7QWGO/ref=ox_sc_act_title_1?ie=UTF8&psc=1&smid=A1ONXNZCOVO2I6', 
		 6 => 'FUJIFILM', 
		 7 => 'CG52FKDKBWTHO', 
		 8 => '2013-08-21 01:59:15', 
		 9 => '2013-08-21 01:59:15', 
	 	)
	 ) 


	 Array ( 
		 [id] => B006T7QWGO 
		 [quantity] => 1 
		 [price] => 141.38 
		 [image] => http://ecx.images-amazon.com/images/I/51lRCYDCtGL._SL500_SS100_.jpg 
		 [name] => Fujifilm FinePix S4200 Digital Camera 
		 [link] => http://www.amazon.com/gp/product/B006T7QWGO/ref=ox_sc_act_title_1?ie=UTF8&psc=1&smid=A1ONXNZCOVO2I6 
		 [creator] => FUJIFILM 
		 [id2] => CG52FKDKBWTHO 
	 ) 




Array ( 
	[id] => B006T7QWGO 
	[quantity] => 1 
	[price] => 141.38 
	[image] => http://ecx.images-amazon.com/images/I/51lRCYDCtGL._SL500_SS100_.jpg 
	[name] => Fujifilm FinePix S4200 Digital Camera 
	[link] => http://www.amazon.com/gp/product/B006T7QWGO/ref=ox_sc_act_title_1?ie=UTF8&psc=1&smid=A1ONXNZCOVO2I6 
	[creator] => FUJIFILM 
	[id2] => CG52FKDKBWTHO 
	[session_id] => va38gm8gfq9ceh2bm7ad98ebh0 
	[ip_address] => 127.0.0.1 
	[merchant_id] => 1 
	[item_id] => B006T7QWGO 
	[designer] => 
	[color] => 
	[size] => 
	[package] => 
	[print_on_demand] => 
	[front_logo] => 
	[custom_back_number] => 
	[custom_back_name] => 
	[price_usd] => 1 
	[price_ksh] => 90.4 
) 


Array ( 
[session_id] => 2jbevr46ht5qgjf37q3uvf4ut4 
[ip_address] => ::1 
[merchant_id] => 9 
[item_id] => ci463289000056 
[name] => Brunello CucinelliHeavy Metal Cashmere Pullover 
[quantity] => 1 
[link] => 
[image] => https://www.neimanmarcus.com/product_assets/B/2/A/X/T/NMB2AXT_mg.jpg 
[designer] => 
[color] => Grey 
[size] => Small 
[package] => 
[print_on_demand] => 
[front_logo] => 
[custom_back_number] => 
[custom_back_name] => 
[price_usd] => 3210 
[price_ksh] => 281377.36 
[md5] => c7c7a94d45cbd28e1ae0561b5a56bf55 ) 


Array ( 
[session_id] => 2jbevr46ht5qgjf37q3uvf4ut4 
[ip_address] => ::1 
[merchant_id] => 24 
[item_id] => 12191573 
[name] => Angry Birds Water Bottle 
[quantity] => 1 
[link] => http://www.toysrus.com/product/index.jsp?productId=12576530&skuid=12191573 
[image] => http://www.toysrus.com/graphics/product_images/pTRU1-12191573t50.jpg 
[designer] => 
[color] => 
[size] => 
[package] => 
[print_on_demand] => 
[front_logo] => 
[custom_back_number] => 
[custom_back_name] => 
[price_usd] => 7.98 
[price_ksh] => 699.49 
[md5] => 78696007b2f8086c49a329df5b490c9d 
)

layout - thin, doublescroll 
check order status
list all my orders
login
checkout
ipn
cc
aws

adminblock
other pages
ssl






{"items":[
{
"image":"http://slimages.macys.com/is/image/MCY/products/3/optimized/1666593_fpx.tif?bgc=255,255,255&wid=100&qlt=90,0&layer=comp&op_sharpen=0&resMode=bicub&op_usm=0.7,1.0,0.5,0&fmt=jpeg",
"name":"INC International Concepts T-Shirt, Monte Split Neck T-Shirt",
"link":"http://www1.macys.com/shop/product/inc-international-concepts-t-shirt-monte-split-neck-t-shirt?ID=964661&upc_ID=31609231&Quantity=3&seqNo=1&EXTRA_PARAMETER=BAG",
"color":"Sonic Plum",
"size":"M",
"id":"964661",
"quantity":3,
"price":14.98
}],
"host":"macys.com"}

array(33) { 
["input"]=> string(1) "{" 
["csrf_token"]=> string(40) "fjDwXoLG6uzIx0L6SEZP3AaCZtHbcIpHaO3W5AFN" 
["loginemail"]=> string(7) "c@c.com" 
["loginpassword"]=> string(1) "c" 
["name"]=> string(0) "" 
["email"]=> string(0) "" 
["phone"]=> string(0) "" 
["password"]=> string(0) "" 
["password_confirmation"]=> string(0) "" 
["city"]=> string(7) "Nairobi" 
["neighbourhood"]=> string(1) "2" 
["payment_type"]=> string(6) "m-pesa" 
["submitorder"]=> string(12) "Submit Order" 
["Lite_Merchant_ApplicationID"]=> string(36) "7ad6b430-0b38-4602-884d-f3e2f1310467" 
["Ecom_BillTo_Postal_Name_First"]=> string(5) "First" 
["Ecom_BillTo_Postal_Name_Last"]=> string(4) "Last" 
["Ecom_BillTo_Telecom_Phone_Number"]=> string(0) "" 
["Ecom_BillTo_Online_Email"]=> string(0) "" 
["Lite_Order_Amount"]=> string(6) "664900" 
["Lite_Order_Terminal"]=> string(3) "Web" 
["Lite_ConsumerOrderID_PreFix"]=> string(4) "Vitu" 
["Lite_On_Error_Resume_Next"]=> string(4) "True" 
["Lite_Order_LineItems_Product_1"]=> string(8) "Subtotal" 
["Lite_Order_LineItems_Quantity_1"]=> string(1) "1" 
["Lite_Order_LineItems_Amount_1"]=> string(6) "664900" 
["Ecom_Payment_Card_Protocols"]=> string(5) "iVeri" 
["Lite_Version_"]=> string(3) "2.0" 
["Ecom_ConsumerOrderID"]=> string(12) "AUTOGENERATE" 
["Ecom_TransactionComplete"]=> string(5) "False" 
["Lite_Website_Successful_url"]=> string(41) "https://www.vitumob.com/iverilite/success" 
["Lite_Website_Fail_url"]=> string(41) "https://www.vitumob.com/iverilite/failure" 
["Lite_Website_TryLater_url"]=> string(42) "https://www.vitumob.com/iverilite/trylater" 
["Lite_Website_Error_url"]=> string(39) "https://www.vitumob.com/iverilite/error" 
}

array(22) { 
["payment_type"]=> string(6) "m-pesa" 
["submitorder"]=> string(12) "Submit Order" 
["Lite_Merchant_ApplicationID"]=> string(36) "7ad6b430-0b38-4602-884d-f3e2f1310467" 
["Ecom_BillTo_Postal_Name_First"]=> string(5) "First" 
["Ecom_BillTo_Postal_Name_Last"]=> string(4) "Last" 
["Ecom_BillTo_Telecom_Phone_Number"]=> string(0) "" 
["Ecom_BillTo_Online_Email"]=> string(0) "" 
["Lite_Order_Amount"]=> string(6) "664900" 
["Lite_Order_Terminal"]=> string(3) "Web" 
["Lite_ConsumerOrderID_PreFix"]=> string(4) "Vitu" 
["Lite_On_Error_Resume_Next"]=> string(4) "True" 
["Lite_Order_LineItems_Product_1"]=> string(8) "Subtotal" 
["Lite_Order_LineItems_Quantity_1"]=> string(1) "1" 
["Lite_Order_LineItems_Amount_1"]=> string(6) "664900" 
["Ecom_Payment_Card_Protocols"]=> string(5) "iVeri" 
["Lite_Version_"]=> string(3) "2.0" 
["Ecom_ConsumerOrderID"]=> string(12) "AUTOGENERATE" 
["Ecom_TransactionComplete"]=> string(5) "False" 
["Lite_Website_Successful_url"]=> string(41) "https://www.vitumob.com/iverilite/success" 
["Lite_Website_Fail_url"]=> string(41) "https://www.vitumob.com/iverilite/failure" 
["Lite_Website_TryLater_url"]=> string(42) "https://www.vitumob.com/iverilite/trylater" 
["Lite_Website_Error_url"]=> string(39) "https://www.vitumob.com/iverilite/error" }

 failed login validation


 array(33) { 
 ["totals"]=> string(122) "{"sub_total":"237,558.86","customs":"6,117.19","shipping":"28,602.74","vat":"3,819.51","total":"276,098.30","notes":"new"}" 
 ["csrf_token"]=> string(40) "fjDwXoLG6uzIx0L6SEZP3AaCZtHbcIpHaO3W5AFN" 
 ["login_email"]=> string(19) "techytimo@gmail.com" 
 ["login_password"]=> string(1) "t" 
 ["name"]=> string(8) "The Devs" 
 ["email"]=> string(10) "t@test.com" 
 ["phone"]=> string(10) "0734567890" 
 ["password"]=> string(1) "t" 
 ["password_confirmation"]=> string(1) "t" 
 ["city"]=> string(7) "Nairobi" 
 ["neighbourhood"]=> string(8) "Muthaiga" 
 ["payment_type"]=> string(6) "m-pesa" 
 ["submitorder"]=> string(12) "Submit Order" 
 ["Lite_Merchant_ApplicationID"]=> string(36) "7ad6b430-0b38-4602-884d-f3e2f1310467" 
 ["Ecom_BillTo_Postal_Name_First"]=> string(3) "The" 
 ["Ecom_BillTo_Postal_Name_Last"]=> string(4) "Devs" 
 ["Ecom_BillTo_Telecom_Phone_Number"]=> string(10) "0734567890" 
 ["Ecom_BillTo_Online_Email"]=> string(10) "t@test.com" 
 ["Lite_Order_Amount"]=> string(6) "664900" 
 ["Lite_Order_Terminal"]=> string(3) "Web" 
 ["Lite_ConsumerOrderID_PreFix"]=> string(4) "Vitu" 
 ["Lite_On_Error_Resume_Next"]=> string(4) "True" 
 ["Lite_Order_LineItems_Product_1"]=> string(8) "Subtotal" 
 ["Lite_Order_LineItems_Quantity_1"]=> string(1) "1" 
 ["Lite_Order_LineItems_Amount_1"]=> string(6) "664900" 
 ["Ecom_Payment_Card_Protocols"]=> string(5) "iVeri" 
 ["Lite_Version_"]=> string(3) "2.0" 
 ["Ecom_ConsumerOrderID"]=> string(12) "AUTOGENERATE" 
 ["Ecom_TransactionComplete"]=> string(5) "False" 
 ["Lite_Website_Successful_url"]=> string(41) "https://www.vitumob.com/iverilite/success" 
 ["Lite_Website_Fail_url"]=> string(41) "https://www.vitumob.com/iverilite/failure" 
 ["Lite_Website_TryLater_url"]=> string(42) "https://www.vitumob.com/iverilite/trylater" 
 ["Lite_Website_Error_url"]=> string(39) "https://www.vitumob.com/iverilite/error" }


 array(2) { 

 [0]=> object(stdClass)#345 (26) { 
 ["id"]=> int(1) 
 ["session_id"]=> string(26) "d1cfn2q29rujb9ea08holkv0j5" 
 ["ip_address"]=> string(0) "" 
 ["order_id"]=> string(4) "9063" 
 ["md5"]=> string(0) "" 
 ["merchant_id"]=> int(0) 
 ["item_id"]=> string(7) "2908146" 
 ["name"]=> string(45) "Playskool Busy Basics Step Start Walk 'n Ride" 
 ["quantity"]=> int(1) 
 ["link"]=> string(72) "http://www.toysrus.com/product/index.jsp?productId=2331997&skuid=2908146" 
 ["image"]=> string(67) "http://www.toysrus.com/graphics/product_images/pTRU1-2908146t50.jpg" 
 ["designer"]=> string(0) "" 
 ["color"]=> string(0) "" 
 ["size"]=> int(0) 
 ["package"]=> string(0) "" 
 ["print_on_demand"]=> string(0) "" 
 ["front_logo"]=> string(0) "" 
 ["custom_back_number"]=> string(0) "" 
 ["custom_back_name"]=> string(0) "" 
 ["part_number"]=> string(0) "" 
 ["price_usd"]=> string(5) "19.99" 
 ["price_ksh"]=> string(4) "1.00" 
 ["status"]=> string(0) "" 
 ["notes"]=> string(0) "" 
 ["created_at"]=> string(19) "0000-00-00 00:00:00" 
 ["updated_at"]=> string(19) "0000-00-00 00:00:00" } 

 [1]=> object(stdClass)#346 (26) { 
 ["id"]=> int(5) 
 ["session_id"]=> string(26) "k5dgcphtnnt6mkuue0s4mgcmr5" 
 ["ip_address"]=> string(0) "" 
 ["order_id"]=> string(4) "9063" 
 ["md5"]=> string(0) "" 
 ["merchant_id"]=> int(0) 
 ["item_id"]=> string(10) "159463176X" 
 ["name"]=> string(24) "And the Mountains Echoed" 
 ["quantity"]=> int(1) 
 ["link"]=> string(98) "http://www.amazon.com/gp/product/159463176X/ref=ox_sc_act_title_2?ie=UTF8&psc=1&smid=ATVPDKIKX0DER" 
 ["image"]=> string(113) "http://ecx.images-amazon.com/images/I/51VqHa8exoL._SL500_PIsitb-sticker-arrow-big,TopRight,35,-73_OU01_SS100_.jpg" 
 ["designer"]=> string(0) "" 
 ["color"]=> string(0) "" 
 ["size"]=> int(0) 
 ["package"]=> string(0) "" 
 ["print_on_demand"]=> string(0) "" 
 ["front_logo"]=> string(0) "" 
 ["custom_back_number"]=> string(0) "" 
 ["custom_back_name"]=> string(0) "" 
 ["part_number"]=> string(0) "" 
 ["price_usd"]=> string(5) "10.84" 
 ["price_ksh"]=> string(6) "980.00" 
 ["status"]=> string(0) "" 
 ["notes"]=> string(0) "" 
 ["created_at"]=> string(19) "0000-00-00 00:00:00" 
 ["updated_at"]=> string(19) "0000-00-00 00:00:00" } }

//redirect back to checkout page withInput

 array(32) { 
 ["csrf_token"]=> string(40) "tAC95jo7TNgtMUHghDY1QFXPauAPL7MptVNqhDks" 
 ["login_email"]=> string(16) "techmo@gmail.com" 
 ["login_password"]=> string(1) "O" 
 ["name"]=> string(0) "" 
 ["email"]=> string(0) "" 
 ["phone"]=> string(0) "" 
 ["password"]=> string(0) "" 
 ["password_confirmation"]=> string(0) "" 
 ["city"]=> string(7) "Nairobi" 
 ["neighbourhood"]=> string(8) "Kasarani" 
 ["payment_type"]=> string(6) "m-pesa" 
 ["submitorder"]=> string(12) "Submit Order" 
 ["Lite_Merchant_ApplicationID"]=> string(36) "7ad6b430-0b38-4602-884d-f3e2f1310467" 
 ["Ecom_BillTo_Postal_Name_First"]=> string(5) "First" 
 ["Ecom_BillTo_Postal_Name_Last"]=> string(4) "Last" 
 ["Ecom_BillTo_Telecom_Phone_Number"]=> string(0) "" 
 ["Ecom_BillTo_Online_Email"]=> string(0) "" 
 ["Lite_Order_Amount"]=> string(6) "664900" 
 ["Lite_Order_Terminal"]=> string(3) "Web" 
 ["Lite_ConsumerOrderID_PreFix"]=> string(4) "Vitu" 
 ["Lite_On_Error_Resume_Next"]=> string(4) "True" 
 ["Lite_Order_LineItems_Product_1"]=> string(8) "Subtotal" 
 ["Lite_Order_LineItems_Quantity_1"]=> string(1) "1" 
 ["Lite_Order_LineItems_Amount_1"]=> string(6) "664900" 
 ["Ecom_Payment_Card_Protocols"]=> string(5) "iVeri" 
 ["Lite_Version_"]=> string(3) "2.0" 
 ["Ecom_ConsumerOrderID"]=> string(12) "AUTOGENERATE" 
 ["Ecom_TransactionComplete"]=> string(5) "False" 
 ["Lite_Website_Successful_url"]=> string(41) "https://www.vitumob.com/iverilite/success" 
 ["Lite_Website_Fail_url"]=> string(41) "https://www.vitumob.com/iverilite/failure" 
 ["Lite_Website_TryLater_url"]=> string(42) "https://www.vitumob.com/iverilite/trylater" 
 ["Lite_Website_Error_url"]=> string(39) "https://www.vitumob.com/iverilite/error"
  }

display input
witherrors
chek for registration

array(12) { ["mode"]=> string(0) "" ["sub_total_usd"]=> string(6) "378.25" ["sub_total_ksh"]=> string(6) "33,156" ["customs_usd"]=> string(5) "56.04" ["customs_ksh"]=> string(5) "4,913" ["shipping_usd"]=> string(5) "75.00" ["shipping_ksh"]=> string(5) "6,574" ["vat_usd"]=> string(5) "34.99" ["vat_ksh"]=> string(5) "3,067" ["total_usd"]=> string(6) "544.29" ["total_ksh"]=> string(6) "47,710" ["submit"]=> string(8) "Checkout" }




deletepop
doublescroll lists
interface
admin dashboard
admin user array

order page chat


recieving payments 



config/app
db settings
functions model
bootstrap/paths
public
404

test mpesa ipn
iveri
mail sending - order status, payment process
aws upload


authenticity always surfaces. no matter how many cups of coffee you pour in there, the cream will always rise to the top. i pride myself for being original and a starter



deletepop
environment configs
ipn test
bookcheetah popular books


UPDATE `items` SET `id`=[value-1],`session_id`=[value-2],`ip_address`=[value-3],`user_id`=[value-4],`order_id`=[value-5],`md5`=[value-6],`merchant_id`=[value-7],`item_id`=[value-8],`name`=[value-9],`quantity`=[value-10],`link`=[value-11],`image`=[value-12],`designer`=[value-13],`color`=[value-14],`size`=[value-15],`package`=[value-16],`print_on_demand`=[value-17],`front_logo`=[value-18],`custom_back_number`=[value-19],`custom_back_name`=[value-20],`part_number`=[value-21],`price_usd`=[value-22],`price_ksh`=[value-23],`status`=[value-24],`notes`=[value-25],`created_at`=[value-26],`updated_at`=[value-27] WHERE 1


AWS loadbalancers, security groups, setting up
stripe ecommerce
credit card processing


save configuration
cloudformation template:
http://gettingstarted.s3.amazonaws.com/rds/template.json


