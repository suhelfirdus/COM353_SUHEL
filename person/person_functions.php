<?php

include('../config.php');

if (isset($_POST['add_new_person'])) {
    $person_id=add_person();
    echo "hello world".$person_id;
    $location ="/COM353/person/person_view.php?person_id=".$person_id;
    header("Location: " . "http://" . $_SERVER['HTTP_HOST'] . $location);

}
if (isset($_POST['update_person_btn'])) {
    $person_id = e($_POST['person_id']);
    echo $person_id;
    $person_id = update_ui_person($person_id);
    $location ="/COM353/person/person_view.php?person_id=".$person_id;
    //header("Location: " . "http://" . $_SERVER['HTTP_HOST'] . $location);

}

if (isset($_POST['delete_person'])) {
    $person_id = e($_POST['person_id']);
    $person_id = delete_person($person_id);
    echo "delete";
    header("Location: person_record.php");

}
function add_person()
{
    global $mysqli;
    $date = date_create();
    echo date_timestamp_get($date);
    //$facility_id=generateRandomString();
    $query = "INSERT INTO person(person_id)VALUES(null)";
    $mysqli->query($query);
    $person_id=$mysqli->insert_id;
    $query = "INSERT INTO address(person_id)VALUES('$person_id')";
    $mysqli->query($query);

    $mysqli->close();
    return  $person_id;
}


function delete_person($person_id)
{
    global $mysqli;
    $facility_id = e($_POST['person_id']);
    $query ="DELETE FROM `person` WHERE `person_id` = $person_id";
    if ($mysqli->query($query) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $query->error;
    }
    $mysqli->close();
    //return $person_id;
}
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function getRelatedPerson(){
    global $db;
    $query = "SELECT person_id,first_name,Last_name,phone_number,street_address from person_det_view";
    $result = mysqli_query($db, $query);
    $numRows=mysqli_num_rows($result);
    $regions = array();
    while ($row = $result->fetch_row()) {
        echo  "<option value=$row[0] > $row[1] $row[2]   - $row[0]</option>";
        $regions[]=$row;
    }

    return $regions;

}
function getAllNationality(){
  echo " <option value=''>-- select one --</option>
  <option value='afghan'>Afghan</option>
  <option value='albanian'>Albanian</option>
  <option value='algerian'>Algerian</option>
  <option value='american'>American</option>
  <option value='andorran'>Andorran</option>
  <option value='angolan'>Angolan</option>
  <option value='antiguans'>Antiguans</option>
  <option value='argentinean'>Argentinean</option>
  <option value='armenian'>Armenian</option>
  <option value='australian'>Australian</option>
  <option value='austrian'>Austrian</option>
  <option value='azerbaijani'>Azerbaijani</option>
  <option value='bahamian'>Bahamian</option>
  <option value='bahraini'>Bahraini</option>
  <option value='bangladeshi'>Bangladeshi</option>
  <option value='barbadian'>Barbadian</option>
  <option value='barbudans'>Barbudans</option>
  <option value='batswana'>Batswana</option>
  <option value='belarusian'>Belarusian</option>
  <option value='belgian'>Belgian</option>
  <option value='belizean'>Belizean</option>
  <option value='beninese'>Beninese</option>
  <option value='bhutanese'>Bhutanese</option>
  <option value='bolivian'>Bolivian</option>
  <option value='bosnian'>Bosnian</option>
  <option value='brazilian'>Brazilian</option>
  <option value='british'>British</option>
  <option value='bruneian'>Bruneian</option>
  <option value='bulgarian'>Bulgarian</option>
  <option value='burkinabe'>Burkinabe</option>
  <option value='burmese'>Burmese</option>
  <option value='burundian'>Burundian</option>
  <option value='cambodian'>Cambodian</option>
  <option value='cameroonian'>Cameroonian</option>
  <option value='canadian'>Canadian</option>
  <option value='cape verdean'>Cape Verdean</option>
  <option value='central african'>Central African</option>
  <option value='chadian'>Chadian</option>
  <option value='chilean'>Chilean</option>
  <option value='chinese'>Chinese</option>
  <option value='colombian'>Colombian</option>
  <option value='comoran'>Comoran</option>
  <option value='congolese'>Congolese</option>
  <option value='costa rican'>Costa Rican</option>
  <option value='croatian'>Croatian</option>
  <option value='cuban'>Cuban</option>
  <option value='cypriot'>Cypriot</option>
  <option value='czech'>Czech</option>
  <option value='danish'>Danish</option>
  <option value='djibouti'>Djibouti</option>
  <option value='dominican'>Dominican</option>
  <option value='dutch'>Dutch</option>
  <option value='east timorese'>East Timorese</option>
  <option value='ecuadorean'>Ecuadorean</option>
  <option value='egyptian'>Egyptian</option>
  <option value='emirian'>Emirian</option>
  <option value='equatorial guinean'>Equatorial Guinean</option>
  <option value='eritrean'>Eritrean</option>
  <option value='estonian'>Estonian</option>
  <option value='ethiopian'>Ethiopian</option>
  <option value='fijian'>Fijian</option>
  <option value='filipino'>Filipino</option>
  <option value='finnish'>Finnish</option>
  <option value='french'>French</option>
  <option value='gabonese'>Gabonese</option>
  <option value='gambian'>Gambian</option>
  <option value='georgian'>Georgian</option>
  <option value='german'>German</option>
  <option value='ghanaian'>Ghanaian</option>
  <option value='greek'>Greek</option>
  <option value='grenadian'>Grenadian</option>
  <option value='guatemalan'>Guatemalan</option>
  <option value='guinea-bissauan'>Guinea-Bissauan</option>
  <option value='guinean'>Guinean</option>
  <option value='guyanese'>Guyanese</option>
  <option value='haitian'>Haitian</option>
  <option value='herzegovinian'>Herzegovinian</option>
  <option value='honduran'>Honduran</option>
  <option value='hungarian'>Hungarian</option>
  <option value='icelander'>Icelander</option>
  <option value='indian'>Indian</option>
  <option value='indonesian'>Indonesian</option>
  <option value='iranian'>Iranian</option>
  <option value='iraqi'>Iraqi</option>
  <option value='irish'>Irish</option>
  <option value='israeli'>Israeli</option>
  <option value='italian'>Italian</option>
  <option value='ivorian'>Ivorian</option>
  <option value='jamaican'>Jamaican</option>
  <option value='japanese'>Japanese</option>
  <option value='jordanian'>Jordanian</option>
  <option value='kazakhstani'>Kazakhstani</option>
  <option value='kenyan'>Kenyan</option>
  <option value='kittian and nevisian'>Kittian and Nevisian</option>
  <option value='kuwaiti'>Kuwaiti</option>
  <option value='kyrgyz'>Kyrgyz</option>
  <option value='laotian'>Laotian</option>
  <option value='latvian'>Latvian</option>
  <option value='lebanese'>Lebanese</option>
  <option value='liberian'>Liberian</option>
  <option value='libyan'>Libyan</option>
  <option value='liechtensteiner'>Liechtensteiner</option>
  <option value='lithuanian'>Lithuanian</option>
  <option value='luxembourger'>Luxembourger</option>
  <option value='macedonian'>Macedonian</option>
  <option value='malagasy'>Malagasy</option>
  <option value='malawian'>Malawian</option>
  <option value='malaysian'>Malaysian</option>
  <option value='maldivan'>Maldivan</option>
  <option value='malian'>Malian</option>
  <option value='maltese'>Maltese</option>
  <option value='marshallese'>Marshallese</option>
  <option value='mauritanian'>Mauritanian</option>
  <option value='mauritian'>Mauritian</option>
  <option value='mexican'>Mexican</option>
  <option value='micronesian'>Micronesian</option>
  <option value='moldovan'>Moldovan</option>
  <option value='monacan'>Monacan</option>
  <option value='mongolian'>Mongolian</option>
  <option value='moroccan'>Moroccan</option>
  <option value='mosotho'>Mosotho</option>
  <option value='motswana'>Motswana</option>
  <option value='mozambican'>Mozambican</option>
  <option value='namibian'>Namibian</option>
  <option value='nauruan'>Nauruan</option>
  <option value='nepalese'>Nepalese</option>
  <option value='new zealander'>New Zealander</option>
  <option value='ni-vanuatu'>Ni-Vanuatu</option>
  <option value='nicaraguan'>Nicaraguan</option>
  <option value='nigerien'>Nigerien</option>
  <option value='north korean'>North Korean</option>
  <option value='northern irish'>Northern Irish</option>
  <option value='norwegian'>Norwegian</option>
  <option value='omani'>Omani</option>
  <option value='pakistani'>Pakistani</option>
  <option value='palauan'>Palauan</option>
  <option value='panamanian'>Panamanian</option>
  <option value='papua new guinean'>Papua New Guinean</option>
  <option value='paraguayan'>Paraguayan</option>
  <option value='peruvian'>Peruvian</option>
  <option value='polish'>Polish</option>
  <option value='portuguese'>Portuguese</option>
  <option value='qatari'>Qatari</option>
  <option value='romanian'>Romanian</option>
  <option value='russian'>Russian</option>
  <option value='rwandan'>Rwandan</option>
  <option value='saint lucian'>Saint Lucian</option>
  <option value='salvadoran'>Salvadoran</option>
  <option value='samoan'>Samoan</option>
  <option value='san marinese'>San Marinese</option>
  <option value='sao tomean'>Sao Tomean</option>
  <option value='saudi'>Saudi</option>
  <option value='scottish'>Scottish</option>
  <option value='senegalese'>Senegalese</option>
  <option value='serbian'>Serbian</option>
  <option value='seychellois'>Seychellois</option>
  <option value='sierra leonean'>Sierra Leonean</option>
  <option value='singaporean'>Singaporean</option>
  <option value='slovakian'>Slovakian</option>
  <option value='slovenian'>Slovenian</option>
  <option value='solomon islander'>Solomon Islander</option>
  <option value='somali'>Somali</option>
  <option value='south african'>South African</option>
  <option value='south korean'>South Korean</option>
  <option value='spanish'>Spanish</option>
  <option value='sri lankan'>Sri Lankan</option>
  <option value='sudanese'>Sudanese</option>
  <option value='surinamer'>Surinamer</option>
  <option value='swazi'>Swazi</option>
  <option value='swedish'>Swedish</option>
  <option value='swiss'>Swiss</option>
  <option value='syrian'>Syrian</option>
  <option value='taiwanese'>Taiwanese</option>
  <option value='tajik'>Tajik</option>
  <option value='tanzanian'>Tanzanian</option>
  <option value='thai'>Thai</option>
  <option value='togolese'>Togolese</option>
  <option value='tongan'>Tongan</option>
  <option value='trinidadian or tobagonian'>Trinidadian or Tobagonian</option>
  <option value='tunisian'>Tunisian</option>
  <option value='turkish'>Turkish</option>
  <option value='tuvaluan'>Tuvaluan</option>
  <option value='ugandan'>Ugandan</option>
  <option value='ukrainian'>Ukrainian</option>
  <option value='uruguayan'>Uruguayan</option>
  <option value='uzbekistani'>Uzbekistani</option>
  <option value='venezuelan'>Venezuelan</option>
  <option value='vietnamese'>Vietnamese</option>
  <option value='welsh'>Welsh</option>
  <option value='yemenite'>Yemenite</option>
  <option value='zambian'>Zambian</option>
  <option value='zimbabwean'>Zimbabwean</option>";
}












