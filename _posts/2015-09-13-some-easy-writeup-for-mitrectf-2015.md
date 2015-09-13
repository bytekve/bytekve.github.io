---
layout: post
title: Some easy writeup for MitreCTF 2015
date: 2015-09-13 11:48
categories: ctf writeup
---
## Crypto 50

~~~
C qogvi. Sio qogvi. By- mby- gy... qogvi. Qogvi; Qogvicha; Qy'ff bupy nbyy qogvi; Qogvilugu; Qogvifias; nby mnoxs iz Qogvi. Cn'm zclmn aluxy, Mjihayviv! GWU-UW56X5YU
~~~

ROT-6:

~~~
I wumbo. You wumbo. He- she- me... wumbo. Wumbo; Wumboing; We'll have thee wumbo; Wumborama; Wumbology; the study of Wumbo. It's first grade, Spongebob! MCA-AC56D5EA
~~~

~~~
Flag: MCA-AC56D5EA
~~~

## Crypto 100 - Message

###[Gravity Falls Cryptogram](http://gravityfalls.wikia.com/wiki/List_of_cryptograms#Author.27s_symbol_substitution_cipher)

![gravity falls](/images/CTF/gravitymessage.png)

~~~
MCA DASH FOUR TWO SIX NINE SIX C SIX C
~~~

Flag: MCA-42696c6c

## Crypto 100 - Srcamble

![scramble](/images/CTF/scramble.png)

~~~python
from PIL import Image
im = Image.open("scramble.png")
width, height = im.size
im2 = Image.new("RGB", (width, height))
def solverow(row, tuple):
    for i in range (5):
        left = i * width/5
        upper = row*height/5
        block = (left, upper, left + width/5, upper + height/5)
        blockimg = im.crop(block)
        k = tuple[i]
        replaceblock = (k*width/5, upper, (k + 1)*width/5, upper + height/5)
        im2.paste(blockimg, replaceblock)
tuples = ((3, 1, 0, 2, 4), (0, 1, 2, 3, 4), (3, 1, 0, 4, 2), (2, 0, 4, 3, 1), (0, 1, 3, 4, 2))
for row in range(5):
    solverow(row, tuples[row])
im2.show()
im2.save('flag.png')
~~~

![flag found](/images/CTF/c100mitreflag.png)

Flag: MCA-9b1a4f1e44

## Web 100 - Geocaching

This problem must be on run on their vpn.

~~~python
import requests
def get_file_content(url):
    resp = requests.get(url)
    return resp.text
def cut_off_zero(number):
    if isinstance(number, float):
        float(number)
    else:
        int(number)
    return number
def translate(text):
    dictionary = ('B', '4', 'D', '7', '3', 'A', '8', '6', '2', '1', '0', '9', 'F', 'E', 'C', '5')
    return ''.join(dictionary[int(i)] for i in text)
def keep_going(location):
    filename = (str(cut_off_zero(location[0])) + 'y' + str(cut_off_zero(location[1]))).replace('-', 'neg').replace('.', 's')+ '.txt'
    url = base_url + '/' + filename
    content = get_file_content(url).split('/')
    print('Your\'re ' + content[0] + 'Have a flag piece! A piece is: ' + content[1])
    print("""
        |
        |
     Go! Go!
        |
        V
    """)
    return content[1]
base_url = 'http://10.0.1.21/3d6b87076c1c-geocaching/'
locations = ((25,-74), (39.1164, 125.8058), (42.504901,-71.236543), (55.7500, 37.6167), (-33.8587,151.2140), (45.5045,-73.5563), (-80,10), (36.112890,-115.171282))
flag = ''
for location in locations:
    flag

     += keep_going(location)
print('Your flag is ' + translate(flag))
~~~

## Crypto 300 - Doctor Message

### [ Circular Gallifreyan ](http://www.shermansplanet.com/gallifreyan)

![doctor message](/images/CTF/messsage_from_the_doctor.png)

Message decoded:

~~~
The flag sounds like emsee a bead cafe
~~~

Flag: MCA-beadcafe ("emsee" for MC, because we know that prefix of flag is "MCA-")
