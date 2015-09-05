---
layout: post
title: MD5 Collision
date: 2015-09-04 20:07
categories: hash break
---
##Introduction
Hãy làm một phép thử:
````
Admin@LEOK-PC /e/md5coll
$ wget https://s3-eu-west-1.amazonaws.com/md5collisions/a.php --no-check-certificate
$ wget https://s3-eu-west-1.amazonaws.com/md5collisions/b.php --no-check-certificate
$ powershell get-filehash -algorithm md5 a.php

Algorithm       Hash
---------       ----
MD5             62E1D0D1620581693435AA75F5B6C964

$ powershell get-filehash -algorithm md5 b.php

Algorithm       Hash
---------       ----
MD5             62E1D0D1620581693435AA75F5B6C964


````
##Explaination
>>MD5 collision

Đó là tất cả những gì bạn có thể tìm kiếm trên google nếu muốn tìm hiểu thêm về những gì đã xảy ra trên đây. Trong giới hạn bài viết và vốn hiểu biết của tôi sẽ không thể trình bày hết về vấn đề này.
###Reference
Một số tài liệu các bạn có thể tham khảo:
*[How to Break MD5 and Other Hash Functions](http://www.infosec.sdu.edu.cn/uploadfile/papers/How%20to%20Break%20MD5%20and%20Other%20Hash%20Functions.pdf)

*[Construct MD5 Collisions Using Just A Single Block Of Message ](http://eprint.iacr.org/2010/643.pdf)

*[Fast Collision Attack on MD5](https://eprint.iacr.org/2013/170.pdf)

*[http://www.mscs.dal.ca/~selinger/md5collision/](http://www.mscs.dal.ca/~selinger/md5collision/)

*[https://marc-stevens.nl/research/](https://marc-stevens.nl/research/)