※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※

-----資料庫連結-----

<?php require __DIR__ . './Connect_DataBase.php'; ?>

※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※

-----HTML宣告-----
<body>標籤在這裡

<?php require __DIR__ . './HTMLSetting.php'; ?>

※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※

-----CSS-----

個人用CSS
<?php require __DIR__ . './CssSetting_YU.php'; ?>
Bootstrap
<?php require __DIR__ . './CssSettingBootstrap.php'; ?>

※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※

-----Nav Bar-----

會員用Nav Bar
<?php require __DIR__ . './Member_Nav.php'; ?>
店家用Nav Bar
<?php require __DIR__ . './Store_Nav.php'; ?>
管理者用Nav Bar
<?php require __DIR__ . './Admin_Nav.php'; ?>

※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※

-----這裡放內容-----

<?php require __DIR__ . './Member_Serchbody.php'; ?>

<?php require __DIR__ . './Store_indexbody.php'; ?>

※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※

-----Footer-----
</body>標籤 還有 /HTML 在這裡

無內容Footer    
<?php require __DIR__. './Footer.php' ?>
有CDN Footer 
<?php require __DIR__. './Footer_CDN.php' ?>

※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※