# basic setup:

# install RVM:   http://rvm.beginrescueend.com/
# use RVM to install ruby 1.8.7
# make an RVM gemset: 1.8.7@watir
# use that gemset
# gem install Firewatir
# install the -jssh plugin for Firefox
# shut down firefox, then run this script  (ruby test1.rb)
# Firefox seems to prefer that at least one FF window is open, or that it is completely shut down, when
#  you run this script.



require 'rubygems'
require 'firewatir'

browser=FireWatir::Firefox.new
# browser = Watir::Browser.new

browser.goto("http://bit.ly/watir-example")

browser.text_field(:name => "entry.0.single").set "Watir"

browser.text_field(:name => "entry.1.single").set "I come here from Australia. \n The weather is great here."

browser.radio(:value => "Watir").set
# browser.radio(:value => "Watir").clear

# browser.checkbox(:value => "Ruby").set
browser.checkbox(:value => "Python").set
# browser.checkbox(:value => "Python").clear

# browser.button(:name => "logon").click
