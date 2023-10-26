#include "gtest/gtest.h"
#include <curl/curl.h>
#include <string>

using namespace std;

unordered_map<string, vector<string>> postData_array {
    {"encrypt",     {"text1=this_is_username",
                     "text2=this_is_password",
                     "key=1234567890",
                     "encrypt=1"}},
    {"encrypt_res", {"9826b7e86505c91cbcf32c3192cf4cec3af6169d3edf9ff9d499c0b21847474d",
                     "9b3e0b10365cd9a54d2c323e01b05ad73af6169d3edf9ff9d499c0b21847474d"}},
    {"decrypt",     {"text1=9826b7e86505c91cbcf32c3192cf4cec3af6169d3edf9ff9d499c0b21847474d",
                     "text2=9b3e0b10365cd9a54d2c323e01b05ad73af6169d3edf9ff9d499c0b21847474d",
                     "key=1234567890",
                     "decrypt=1"}},
    {"decrypt_res", {"this_is_username",
                     "this_is_password"}},
};

string url = "localhost";

size_t WriteCallback(void* contents, size_t size, size_t nmemb, string* userp) {
    size_t totalSize = size * nmemb;
    userp->append(static_cast<char*>(contents), totalSize);
    return totalSize;
}

TEST(AES_Test, Encrypt) {
    CURL* curl = curl_easy_init();
    ASSERT_NE(curl, nullptr);

    curl_easy_setopt(curl, CURLOPT_URL, url.c_str());

    string postData;
    for (auto data : postData_array["encrypt"]) {
        if (!postData.empty())
            postData += "&";

        postData += data;
    }
    curl_easy_setopt(curl, CURLOPT_POSTFIELDS, postData.c_str());

    string response;
    curl_easy_setopt(curl, CURLOPT_WRITEFUNCTION, WriteCallback);
    curl_easy_setopt(curl, CURLOPT_WRITEDATA, &response);

    CURLcode res = curl_easy_perform(curl);
    ASSERT_EQ(res, CURLE_OK);

    curl_easy_cleanup(curl);

    for (auto data : postData_array["encrypt_res"]) {
        EXPECT_NE(response.find(data), string::npos);
    }
}

TEST(AES_Test, Decrypt) {
    CURL* curl = curl_easy_init();
    ASSERT_NE(curl, nullptr);

    curl_easy_setopt(curl, CURLOPT_URL, url.c_str());

    string postData;
    for (auto data : postData_array["decrypt"]) {
        if (!postData.empty())
            postData += "&";

        postData += data;
    }

    curl_easy_setopt(curl, CURLOPT_POSTFIELDS, postData.c_str());

    string response;
    curl_easy_setopt(curl, CURLOPT_WRITEFUNCTION, WriteCallback);
    curl_easy_setopt(curl, CURLOPT_WRITEDATA, &response);

    CURLcode res = curl_easy_perform(curl);
    ASSERT_EQ(res, CURLE_OK);

    curl_easy_cleanup(curl);

    for (auto data : postData_array["decrypt_res"]) {
        EXPECT_NE(response.find(data), string::npos);
    }
}

int main(int argc, char** argv) {
    ::testing::InitGoogleTest(&argc, argv);
    return RUN_ALL_TESTS();
}




