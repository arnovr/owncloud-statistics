<?php
/**
 * This script just fills up the table oc_uc_storageusage for some basic testing
 */
include('/var/www/owncloud/config/config.php');
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
$connect = mysqli_connect('localhost', $CONFIG['dbuser'], $CONFIG['dbpassword'], 'owncloud');
$usernames = ['admin'];

for($i = 0; $i < 500; $i++)
{
    $usernames[] = generateRandomString(15);
}
$now = new \DateTime();
foreach(array(2015,2016) as $year)
{
    for($i = 1; $i < 13; $i++)
    {
        for($j = 1; $j < 31; $j++)
        {
            for($k = 1; $k < 23; $k++) {

                $created = new \DateTime();
                $created->setDate($year, $i, $j);
                $created->setTime(
                    $k,
                    rand(1, 59)
                );
                if ($now < $created) {
                    exit;
                }
                foreach ($usernames as $username) {
                    $usage = rand(100000, 2000000);
                    $sql = 'INSERT INTO oc_uc_storageusage (created, username, `usage`) VALUES ("' . $created->format('Y-m-d H:i:00') . '", "' . $username . '", ' . $usage . ');';
                    $result = mysqli_query($connect, $sql);
                }
            }
        }
    }
}