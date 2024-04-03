<?php
$cookie_name1 = "num";
$cookie_value1 = "";
$cookie_name2 = "op";
$cookie_value2 = "";

if (isset($_POST['num'])) {
    if ($_POST['num'] == 'c') {
        $num = "";
    } elseif ($_POST['num'] == '.') {
        // Check if the decimal point already exists in the input
        if (strpos($_POST['input'], '.') === false) {
            $num = isset($_POST['input']) ? $_POST['input'] . $_POST['num'] : '0' . $_POST['num'];
        } else {
            $num = $_POST['input'];
        }
    } elseif ($_POST['num'] == '+/-') {
        // Toggle positive/negative sign
        $num = isset($_POST['input']) && is_numeric($_POST['input']) ? -$_POST['input'] : '';
    } else {
        $num = isset($_POST['input']) ? $_POST['input'] . $_POST['num'] : $_POST['num'];
    }
} else {
    $num = isset($_POST['input']) ? $_POST['input'] : "";
}

if (isset($_POST['op'])) {
    if ($_POST['input'] != '') {
        $cookie_value1 = $_POST['input'];
        setcookie($cookie_name1, $cookie_value1, time() + (86400 * 30), "/");
    }
    $cookie_value2 = $_POST['op'];
    setcookie($cookie_name2, $cookie_value2, time() + (86400 * 30), "/");
    $num = "";
}

if (isset($_POST['c'])) {
    $num = "";
    // Clear any stored values
    setcookie($cookie_name1, "", time() - 3600, "/"); // Clear the number cookie
    setcookie($cookie_name2, "", time() - 3600, "/"); // Clear the operator cookie
}


if (isset($_POST['ce'])) {
    $num = "";
}

if (isset($_POST['equal'])) {
    if ($_COOKIE['op'] && $_POST['input'] != '') {
        $num = $_POST['input'];
        switch ($_COOKIE['op']) {
            case "+":
                $result = $_COOKIE['num'] + $num;
                break;
            case "-":
                $result = $_COOKIE['num'] - $num;
                break;
            case "*":
                $result = $_COOKIE['num'] * $num;
                break;
            case "/":
                if ($num != 0) {
                    $result = $_COOKIE['num'] / $num;
                } else {
                    $result = "Error: Division by zero!";
                }
                break;
            case "%":
                $result = $_COOKIE['num'] % $num;
                break;
            default:
                $result = "Error: Invalid operator!";
        }
        $num = $result;
    }
    setcookie($cookie_name1, $result, time() + (86400 * 30), "/");
    $num = $result;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculator</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="calc">
        <form action="" method="post">
            <br>
            <input type="text" class="maininput" name="input" value="<?php echo htmlspecialchars($num); ?>"> <br> <br>
            <input type="submit" class="calbtn" name="op" value="+">
            <input type="submit" class="calbtn" name="op" value="-">
            <input type="submit" class="calbtn" name="op" value="*">
            <input type="submit" class="calbtn" name="op" value="/"><br><br>
            
            <input type="submit" class="numbtn" name="num" value="7">
            <input type="submit" class="numbtn" name="num" value="8">
            <input type="submit" class="numbtn" name="num" value="9">
            <input type="submit" class="calbtn modulo" name="op" value="%"><br><br>
            
            <input type="submit" class="numbtn" name="num" value="4">
            <input type="submit" class="numbtn" name="num" value="5">
            <input type="submit" class="numbtn" name="num" value="6">
            <input type="submit" class="ce" name="ce" value="CE"><br><br>
            
            <input type="submit" class="numbtn" name="num" value="1">
            <input type="submit" class="numbtn" name="num" value="2">
            <input type="submit" class="numbtn" name="num" value="3">
            <input type="submit" class="c" name="c" value="C">
            
            <input type="submit" class="numbtn decimal" name="num" value=".">
            <input type="submit" class="numbtn" name="num" value="0">
            <input type="submit" class="equal" name="equal" value="=">
            <input type="submit" class="calbtn toggle" name="num" value="+/-">
        </form>
    </div>
</body>
</html>
