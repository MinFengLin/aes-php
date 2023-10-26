<!DOCTYPE html>
<html>

<head>
    <title>加密/解密</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/clipboard.min.js"></script>
</head>

<body class="bg-light">
    <div class="container py-5">
        <h2 class="mb-4">加密/解密</h2>
        <form method="post" class="bg-white p-4 border rounded">
            <div class="form-group">
                <label for="text">要加密/解密的內容:</label>
                <input type="password" name="text1" id="text1" class="form-control text-input" placeholder="要被加密或解密的字串" required>
                <input type="password" name="text2" id="text2" class="form-control text-input mt-2" placeholder="">
                <input type="password" name="text3" id="text3" class="form-control text-input mt-2" placeholder="">
            </div>
            <div class="form-group">
                <label for="key">鑰匙:</label>
                <input type="password" name="key" id="key" class="form-control text-input" placeholder="加密或解密用的鑰匙, 最多16個字, 用一個自己容易記住的 (請牢記)" required maxlength="16">
            </div>
            <div class="form-group">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="showText">
                    <label class="form-check-label" for="showText">
                        顯示密碼
                    </label>
                </div>
            </div>
            <div class="form-group">
                <input type="submit" name="encrypt" value="加密" class="btn btn-primary">
                <input type="submit" name="decrypt" value="解密" class="btn btn-secondary">
            </div>
        </form>

        <?php
        if (isset($_POST['encrypt'])) {
            $texts = array_filter(array($_POST['text1'], $_POST['text2'], $_POST['text3']));
            $key = $_POST['key'];

            // 補足16個字
            $key = str_pad($key, 16, "\0");

            // 加密
            $encrypted_texts = [];
            foreach ($texts as $text) {
                $encrypted = openssl_encrypt($text, 'AES-128-ECB', $key, OPENSSL_RAW_DATA);
                $encrypted_hex = bin2hex($encrypted);
                $encrypted_texts[] = $encrypted_hex;
            }

            // 輸出加密結果
            echo '<div class="alert alert-primary" role="alert">';
            echo '    <div class="form-check">';
            echo '        <input class="form-check-input" type="checkbox" id="useCopy" checked>';
            echo '        <label class="form-check-label ml-2" for="useCopy">';
            echo '            複製按鈕';
            echo '        </label>';
            echo '    </div>';
            echo '<span>加密:</span>';
            echo '<label class="form-check-label ml-2" for="useCopy"></label>';
            echo '<ul>';
            foreach ($encrypted_texts as $index => $encrypted_text) {
                if (!empty($encrypted_text)) {
                    $textId = 'text-' . $index;
                    echo '<li>';
                    echo '<span id="' . $textId . '">' . $encrypted_text . '</span>';
                    echo '<button class="btn btn-sm btn-primary ml-2" data-clipboard-target="#' . $textId . '">複製</button>';
                    echo '<span id="copy-success-' . $index . '" class="ml-2 d-none" style="background-color: transparent; border: none;">✔</span>';
                    echo '</li>';
                }
            }
            echo '</ul>';
            echo '</div>';
        }

        if (isset($_POST['decrypt'])) {
            $encrypted_hexes = array_filter(array($_POST['text1'], $_POST['text2'], $_POST['text3']));
            $key = $_POST['key'];

            // 補足16個字
            $key = str_pad($key, 16, "\0");

            // 解密
            $decrypted_texts = [];
            foreach ($encrypted_hexes as $encrypted_hex) {
                $encrypted = hex2bin($encrypted_hex);
                $decrypted = openssl_decrypt($encrypted, 'AES-128-ECB', $key, OPENSSL_RAW_DATA);
                $decrypted_texts[] = $decrypted;
            }

            // 輸出解密結果        
            echo '<div class="alert alert-secondary" role="alert">';
            echo '    <div class="form-check">';
            echo '        <input class="form-check-input" type="checkbox" id="useCopy" checked>';
            echo '        <label class="form-check-label ml-2" for="useCopy">';
            echo '            複製按鈕';
            echo '        </label>';
            echo '    </div>';
            echo '<span>解密:</span>';
            echo '<label class="form-check-label ml-2" for="useCopy"></label>';
            echo '<ul>';
            foreach ($decrypted_texts as $index => $decrypted_text) {
                if (!empty($decrypted_text)) {
                    $textId = 'text-' . $index;
                    echo '<li>';
                    echo '<span id="' . $textId . '">' . $decrypted_text . '</span>';
                    echo '<button class="btn btn-sm btn-secondary ml-2" data-clipboard-target="#' . $textId . '">複製</button>';
                    echo '<span id="copy-success-' . $index . '" class="ml-2 d-none" style="background-color: transparent; border: none;">✔</span>';
                    echo '</li>';
                }
            }
            echo '</ul>';
            echo '</div>';
        }
        ?>
    </div>

    <!-- Bootstrap JavaScript -->
    <script src="js/jquery-3.3.1.slim.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

    <script>
        var clipboard = new Clipboard('.btn');
        clipboard.on('success', function (e) {
            var successBadgeId = e.trigger.getAttribute('data-clipboard-target').replace('#text-', 'copy-success-');
            var successBadge = document.getElementById(successBadgeId);
            successBadge.classList.remove('d-none');
            setTimeout(function () {
                successBadge.classList.add('d-none');
            }, 2000);
        });

        var showTextCheckbox = document.getElementById('showText');
        showTextCheckbox.addEventListener('change', function () {
            document.querySelectorAll('.text-input').forEach(function (textInput) {
                if (showTextCheckbox.checked) {
                    textInput.type = 'text';
                } else {
                    textInput.type = 'password';
                }
            });
        });

        var useCopy = document.getElementById('useCopy');
        useCopy.addEventListener('change', function () {
            if (this.checked) {
                document.querySelectorAll('.btn[data-clipboard-target]').forEach(function (button) {
                    button.style.display = 'inline-block';
                });
            } else {
                document.querySelectorAll('.btn[data-clipboard-target]').forEach(function (button) {
                    button.style.display = 'none';
                });
            }
        });
    </script>
</body>

</html>
<!-- Footer -->
<!-- Copy from https://codepen.io/mdbootstrap/pen/poNxRgy -->
<footer class="bg-primary text-center text-white">
  <!-- Grid container -->
  <div class="container p-4">




  </div>
  <!-- Grid container -->

  <!-- Copyright -->
  <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2)">
    © 2023 Copyright:
    <a class="text-white" href="https://github.com/MinFengLin">MinfengLin</a>
  </div>
  <!-- Copyright -->

</footer>
<!-- Footer -->