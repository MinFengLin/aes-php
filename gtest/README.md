```
apt install libgtest-dev cmake g++ libcurl4-openssl-dev
cmake --version
cd /usr/src/gtest
mkdir build 
cmake .. && make
cd lib/
cp -r libgtest* /usr/local/lib/
cd ${work_dir}/gtest

g++ -o test aes_php-gtest.cpp -lgtest -lpthread -lcurl
./test
```
```
TEST_SERVER_IP: 192.168.16.2:8080
[==========] Running 2 tests from 1 test suite.
[----------] Global test environment set-up.
[----------] 2 tests from AES_Test
[ RUN      ] AES_Test.Encrypt
[       OK ] AES_Test.Encrypt (4 ms)
[ RUN      ] AES_Test.Decrypt
[       OK ] AES_Test.Decrypt (0 ms)
[----------] 2 tests from AES_Test (5 ms total)

[----------] Global test environment tear-down
[==========] 2 tests from 1 test suite ran. (5 ms total)
[  PASSED  ] 2 tests.
```