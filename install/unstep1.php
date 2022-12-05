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
                <td><input type="checkbox" name="savedata" id="id_savedata" value="Y"></td>
                <td><p><label for="id_savedata"><?echo GetMessage("MOD_UNINST_SAVE_TABLES")?></label></p></td>
            </tr>
        </table>

        <?=bitrix_sessid_post()?>
        <input type="hidden" name="lang" value="<?echo LANG?>" />
        <input type="hidden" name="id" value="batov.shop" />
        <input type="hidden" name="uninstall" value="Y" />
        <input type="hidden" name="step" value="2" />
        <?echo CAdminMessage::ShowMessage(GetMessage("MOD_UNINST_WARN"))?>
        <input type="submit" value="<?echo GetMessage("MOD_UNINST_DEL")?>" />
    </form>
<?
endif;