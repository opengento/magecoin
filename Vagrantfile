# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.configure("2") do |config|
  config.vm.box = "ubuntu/xenial64"
  
  config.vm.network "private_network", ip: "10.33.33.33"
  config.vm.synced_folder ".", "/vagrant", type: "nfs"

  config.ssh.forward_agent = true

  config.vm.provider :virtualbox do |vb|
    vb.customize ["modifyvm", :id, "--memory", "1024", "--cpus", "1"]
    vb.name = "magecoin.open"
  end

  config.vm.provision :shell, :path => "bootstrap.sh", :args => "magecoin.open"

end
