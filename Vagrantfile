VAGRANTFILE_API_VERSION = "2"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|
  config.vm.box = "ubuntu/trusty64"

  config.vm.network "private_network", ip: "192.168.12.12"
  config.vm.hostname = "statistics.box"

  config.vm.synced_folder "./", "/var/www/apps/statistics", owner:  "www-data", group: "www-data"
end