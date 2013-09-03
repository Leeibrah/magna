http://amzn.to/11o12YH
current running version (beta 1.7).

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


mysqldump signs -h signs.c3x4aregvxxx.us-east-1.rds.amazonaws.com -P 3306 -u cartersxxx -pxxxxxx | mysql -u root -pxxxxxx signs

mysqldump -h vitumob-instance.cskqeiwdvosu.us-west-2.rds.amazonaws.com -P 3306 -u vitumob -pvitu_mob#123 vitumob > C:\Users\guru\Downloads\bp.sql

mysql -h vitumob-instance.cskqeiwdvosu.us-west-2.rds.amazonaws.com -P 3306 -u vitumob -pvitu_mob#123
mysql -h new-vitumob.cskqeiwdvosu.us-west-2.rds.amazonaws.com -P 3306 -u vitumob -pvitu_mob#123

mysql -h timtestinstance.cr3nil4f6zic.us-east-1.rds.amazonaws.com -P 3306 -u tim -ptim

mysql -h tim-rds.cskqeiwdvosu.us-west-2.rds.amazonaws.com -P 3306 -u vitumob -pvitu_mob#123
mysqldump -h tim-rds.cskqeiwdvosu.us-west-2.rds.amazonaws.com -P 3306 -u vitumob -pvitu_mob#123 vitumob > C:\Users\guru\Downloads\backup.sql
# mysqldump -h localhost -u root -p bookcheetah_demo > C:\Users\guru\Downloads\backup.sql
create table timtable (personid int(50) not null auto_increment primary key,firstname varchar(35),middlename varchar(50),lastnamevarchar(50) default 'bato')


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
oxD1m2IRAY2PwPF4xE/oFvAPRKDe0hJpdUkCIDRiyCieC+VF5oNM/prradLkfAAd4XyzKiM=
-----END RSA PRIVATE KEY-----


All of the AMIs you have access to, and there are a lot. 
ec2-describe-images -a

Alternatively you can list just the images Amazon has:
ec2-describe-images -o amazon

vitumob AMI: amzn-ami-pv-2012.09.0.i386-ebs (ami-2231bf12)
Zone: us-west-2b	Security Groups: awseb-e-uii82bmwmi-stack-AWSEBSecurityGroup-11UBEQ2EG9GEF

rds-create-db-instance --engine MySQL5.1 --db-name timtest --db-instance-identifier timtestinstance --allocated-storage 5 --db-instance-class db.m1.xlarge –-header

contact@vitumob.com

SELECT * INTO OUTFILE '/tmp/vitumob.csv' FIELDS TERMINATED BY ',' ENCLOSED BY '"' ESCAPED BY '\\' LINES TERMINATED BY '\n' FROM vitumob

mysql -u vitumob -pvitu_mob#123 --database=vitumob  -e "select * FROM cart" > cart.csv

-e "select * from cart"  | sed 's/\t/","/g;s/^/"/;s/$/"/;s/\n//g' > timfile.csv

mysql -h vitumob-instance.cskqeiwdvosu.us-west-2.rds.amazonaws.com -P 3306 -u vitumob -pvitu_mob#123 vitumob 

ec2-54-213-60-222.us-west-2.compute.amazonaws.com

