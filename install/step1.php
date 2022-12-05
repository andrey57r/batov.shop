<?php

/** @global CMain $APPLICATION */
if (!check_bitrix_sessid())
    return;

if($ex = $APPLICATION->GetException()):
    echo CAdminMessage::ShowMessage(Array(
        "TYPE" => "ERROR",
        "MESSAGE" => GetMessage("MOD_INST_ERR"),
        "DETAILS" => $ex->GetString(),
        "HTML" => true,
    ));
else:

    ?>
    <form action="<?echo $APPLICATION->GetCurPage()?>" name="form1">

        <table>
            <tr>
                <td><input type="checkbox" name="clear_db" id="id_clear_db" value="Y"></td>
                <td><p><label for="id_clear_db"><?= GetMessage("BATOV_SHOP_CLEAR_DB") ?></label></p></td>
            </tr>
        </table>

        <?=bitrix_sessid_post()?>
        <input type="hidden" name="lang" value="<?echo LANG?>" />
        <input type="hidden" name="id" value="batov.shop" />
        <input type="hidden" name="install" value="Y" />
        <input type="hidden" name="step" value="2" />
        <input type="submit" name="" value="<?echo GetMessage("MOD_BACK")?>">
        <input type="submit" value="<?echo GetMessage("MOD_INSTALL")?>" />
    </form>
<?
endif;