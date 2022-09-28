//引用這個JS 並且執行函式 checkLogin(who); who值: 0 會員   ||   1 店家      ||   2 管理者   引用後自動導向
//以下整段複製放入頁面最上方亦可
//<script src="./API/Log/CheckLoginScript.js"></script><script>checkLogin(0);</script>          會員
//<script src="./API/Log/CheckLoginScript.js"></script><script>checkLogin(1);</script>          店家
//<script src="./API/Log/CheckLoginScript.js"></script><script>checkLogin(2);</script>          管理者
function checkLogin(who) {
    //會員
    if (who == 0) {
        fetch("./API/Log/Member_islogin_api.php").then(r => r.json()).then(res => {
            if (res == 0) {
                alert("請先登入");
                location.href = "Member_login.php";
            }
        })
    }
    //店家
    else if (who == 1) {
        fetch("./API/Log/Store_islogin_api.php").then(r => r.json()).then(res => {
            if (res == 0) {
                alert("請先登入");
                location.href = "Store_login.php";
            }
        })
    }
    //管理者
    else if (who == 2) {
        fetch("./API/Log/Admin_islogin_api.php").then(r => r.json()).then(res => {
            if (res == 0) {
                alert("請先登入");
                location.href = "./API/Log/Store_logout_api.php";
            }
        })
    }
}
