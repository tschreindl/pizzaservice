Vagrant.configure("2") do |config|
  config.vm.box = "cmrowles/ubuntu16-xenial"
  config.vm.network :forwarded_port, guest: 80, host: 4567
  config.vm.network :forwarded_port, guest: 3306, host: 5678

  config.vm.provider "virtualbox" do |vb|
      vb.customize [ "modifyvm", :id, "--uartmode1", "disconnected" ]
    end
end