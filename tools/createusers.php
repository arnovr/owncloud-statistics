<?php
/**
 * This script just fills up the table oc_uc_storageusage for some basic testing
 */
use Arnovr\OwncloudProvisioning\ApiConnection;
use Arnovr\OwncloudProvisioning\ProvisioningClient;
use Arnovr\OwncloudProvisioning\ResponseParser\XMLResponseParser;
use GuzzleHttp\Client;

include('/var/www/owncloud/config/config.php');
include('../vendor/autoload.php');
$provisioningClient = new ProvisioningClient(
    new ApiConnection(
        new Client(),
        'http://localhost/ocs/v1.php/cloud',
        'admin',
        'admin',
        5 //timeout is optional
    ),
    new XMLResponseParser()
);

$connect = mysqli_connect('localhost', $CONFIG['dbuser'], $CONFIG['dbpassword'], 'owncloud');
$result = mysqli_query($connect, "select username from oc_uc_storageusage GROUP by username");

while($row = $result->fetch_assoc()){
    $provisioningClient->createUser(new \Arnovr\OwncloudProvisioning\Command\CreateUser($row['username'], 'password'));
    echo "Added " . $row['username'] . " \n";
}
