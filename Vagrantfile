Vagrant.require_version ">= 1.6.0"
Vagrant.configure("2") do |config|

  config.vm.define :munkirjat do |config|

    config.vm.synced_folder ".", "/vagrant", :nfs => true
    config.vm.box = "precise64"
    config.vm.box_url = "http://files.vagrantup.com/precise64.box"
    config.vm.network :private_network, ip: "192.168.111.249"
    config.vm.hostname = "munkirjat"

    config.vm.provider "virtualbox" do |v|
      # Uncomment to enable virtualmachine boot debug
      #v.gui = true
      v.customize ["modifyvm", :id, "--memory", "2048"]
    end

    config.vm.provision :ansible do |ansible|
      ansible.playbook = "provisioning/site.yml"
      ansible.inventory_path = "provisioning/ansible_hosts"
      # Uncomment to enable Ansible verbose mode
      ansible.verbose = 'vvvv' # range 'v' ... 'vvvv'
      #ansible.skip_tags = 'production'
    end
  end
end