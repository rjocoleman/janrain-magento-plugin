require 'rubygems'
require 'firewatir'

require "#{ENV['MAGENTO_1d5_PLUGIN']}/watir-testing/tests/ruby_lib/lib.rb"
require "#{ENV['MAGENTO_1d5_PLUGIN']}/watir-testing/tests/sanity/sanity1.rb"
require "#{ENV['MAGENTO_1d5_PLUGIN']}/watir-testing/tests/plugin_setup/configure_plugin.rb"


#####################################################
# parse arguments coming in from the command line.

# whether to rebuild the database and reset the user admin settings
rebuilddb = false

ARGV.each do |a|
  case a
    when "rebuilddb"
      rebuilddb = true
      puts "will reset Magento settings to baseline install state."
  end
end


if rebuilddb

  # the calling script is responsible for dropping and recreating the tables.
  # this script will call the admin interface to reset several things on Magento
  # before the tests run.

end


# todo remove me
exit


#####################################################
# get things ready for the tests

puts "starting up browser..."
$browser = Watir::Browser.new


#####################################################
# run the tests
if $browser

  puts "browser ready: #{$browser}"

  # simple tests, that Magento is running, admin is available, and Janrain/Engage are in left nav
  # sanity_1_tests $browser

  # try setting up the plugin, try placing the login widget, try placing the social publishing widget
  configure_plugin_tests $browser


  # try creating a user from 3PP

  # try creating a user and then adding 3PP

  # try removing 3PP from user

  # try doing social publishing

else

  raise "unable to start browser"

end

puts "done with all tests"