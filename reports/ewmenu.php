<?php

// Menu
$RootMenu = new cMenu("RootMenu", TRUE);
$RootMenu->AddMenuItem(1, "mi_client", $Language->MenuPhrase("1", "MenuText"), "clientlist.php", -1, "", IsLoggedIn() || AllowListMenu('{3FC7CB86-1F85-46A6-9781-36E2788B8DB5}client'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(2, "mi_client_comp", $Language->MenuPhrase("2", "MenuText"), "client_complist.php", -1, "", IsLoggedIn() || AllowListMenu('{3FC7CB86-1F85-46A6-9781-36E2788B8DB5}client_comp'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(3, "mi_client_details", $Language->MenuPhrase("3", "MenuText"), "client_detailslist.php", -1, "", IsLoggedIn() || AllowListMenu('{3FC7CB86-1F85-46A6-9781-36E2788B8DB5}client_details'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(4, "mi_dar", $Language->MenuPhrase("4", "MenuText"), "darlist.php", -1, "", IsLoggedIn() || AllowListMenu('{3FC7CB86-1F85-46A6-9781-36E2788B8DB5}dar'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(5, "mi_dar_act_req", $Language->MenuPhrase("5", "MenuText"), "dar_act_reqlist.php", -1, "", IsLoggedIn() || AllowListMenu('{3FC7CB86-1F85-46A6-9781-36E2788B8DB5}dar_act_req'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(6, "mi_dar_view_comp", $Language->MenuPhrase("6", "MenuText"), "dar_view_complist.php", -1, "", IsLoggedIn() || AllowListMenu('{3FC7CB86-1F85-46A6-9781-36E2788B8DB5}dar_view_comp'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(7, "mi_users", $Language->MenuPhrase("7", "MenuText"), "userslist.php", -1, "", IsLoggedIn() || AllowListMenu('{3FC7CB86-1F85-46A6-9781-36E2788B8DB5}users'), FALSE, FALSE, "");
echo $RootMenu->ToScript();
?>
<div class="ewVertical" id="ewMenu"></div>
