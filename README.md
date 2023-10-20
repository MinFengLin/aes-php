# aes-php
## Why ##
- 對於一些不常輸入的密碼總是記不住, 因為都用Face ID登入就好, 尤其是銀行的App.
- 若換手機或是被登出了, 儘管用一些暗語來記錄, 但不常用還是會忘記, 總是要使用忘記密碼或忘記使用者代號, 這是很煩人的. 但又不想把密碼明碼的方式貼在記事本.
- 為了可以隨時隨地使用, 因此用網頁的方式來實現. 
## How to use ##
- 透過此方式, 我們僅需要記得一個密碼就好.
![Demo](https://github.com/MinFengLin/aes-php/blob/main/aes_demo.JPG)
### 加密 ###
```
text1: this_is_username
text2: this_is_password
key: 1234567890
-- Click 加密 Button --
結果 1: 9826b7e86505c91cbcf32c3192cf4cec3af6169d3edf9ff9d499c0b21847474d
結果 2: 9b3e0b10365cd9a54d2c323e01b05ad73af6169d3edf9ff9d499c0b21847474d
```
### 解密 ###
```
text1: 9826b7e86505c91cbcf32c3192cf4cec3af6169d3edf9ff9d499c0b21847474d
text2: 9b3e0b10365cd9a54d2c323e01b05ad73af6169d3edf9ff9d499c0b21847474d
key: 1234567890
-- Click 解密 Button --
結果 1: this_is_username
結果 2: this_is_password
```
