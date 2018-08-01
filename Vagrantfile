# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.configure("2") do |config|
  config.vm.box = "ubuntu/xenial64"

   config.vm.synced_folder "codigo", "/var/www/html/codigo"
   config.vm.network "forwarded_port", guest: 80, host: 8080, host_ip: "127.0.0.1"
   config.vm.network "forwarded_port", guest: 9000, host: 8081, host_ip: "127.0.0.1"

  # Disable automatic box update checking. If you disable this, then
  # boxes will only be checked for updates when the user runs
  # `vagrant box outdated`. This is not recommended.
  # config.vm.box_check_update = false

  # Create a forwarded port mapping which allows access to a specific port
  # within the machine from a port on the host machine. In the example below,
  # accessing "localhost:8080" will access port 80 on the guest machine.
  # NOTE: This will enable public access to the opened port
  # config.vm.network "forwarded_port", guest: 80, host: 8080

  # Create a forwarded port mapping which allows access to a specific port
  # within the machine from a port on the host machine and only allow access
  # via 127.0.0.1 to disable public access
  # config.vm.network "forwarded_port", guest: 80, host: 8080, host_ip: "127.0.0.1"

  # Create a private network, which allows host-only access to the machine
  # using a specific IP.
  # config.vm.network "private_network", ip: "192.168.33.10"

  # Create a public network, which generally matched to bridged network.
  # Bridged networks make the machine appear as another physical device on
  # your network.
  # config.vm.network "public_network"

  # Share an additional folder to the guest VM. The first argument is
  # the path on the host to the actual folder. The second argument is
  # the path on the guest to mount the folder. And the optional third
  # argument is a set of non-required options.
  # config.vm.synced_folder "../data", "/vagrant_data"

  # Provider-specific configuration so you can fine-tune various
  # backing providers for Vagrant. These expose provider-specific options.
  # Example for VirtualBox:
  #
  # config.vm.provider "virtualbox" do |vb|
  #   # Display the VirtualBox GUI when booting the machine
  #   vb.gui = true
  #
  #   # Customize the amount of memory on the VM:
  #   vb.memory = "1024"
  # end
  #
  # View the documentation for the provider you are using for more
  # information on available options.

  # Enable provisioning with a shell script. Additional provisioners such as
  # Puppet, Chef, Ansible, Salt, and Docker are also available. Please see the
  # documentation for more information about their specific syntax and use.
   config.vm.provision "shell", inline: <<-SHELL
     sudo apt update
     sudo apt upgrade
     sudo apt install -y git
     sudo apt-get install -y apache2
     #!/usr/bin/env bash
     debconf-set-selections <<< 'mysql-server mysql-server/root_password password n0m3l0'
     debconf-set-selections <<< 'mysql-server mysql-server/root_password_again password n0m3l0'
     sudo apt install -y mysql-server
     sudo apt-get install -y curl php-cli php-mbstring unzip php-xml php libapache2-mod-php php-mcrypt php-mysql
     cd ~
     curl -sS https://getcomposer.org/installer -o composer-setup.php
     sudo php composer-setup.php --install-dir=/usr/local/bin --filename=composer
     cd /var/www/html/codigo
     composer update  
     sudo systemctl restart apache2
   SHELL

end
