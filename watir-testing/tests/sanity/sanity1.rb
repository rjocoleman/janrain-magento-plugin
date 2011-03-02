require 'rubygems'
require 'firewatir'
require "#{ENV['MAGENTO_1d5_PLUGIN']}/watir-testing/tests/ruby_lib/lib.rb"

def sanity_1_tests browser

  puts "sanity1 tests..."

  [
          # Magento index page
  "#{ENV['MGP_ROOT']}/",

  ].each do |url|

    begin
      puts "trying #{url}"
      result = try_url "#{url}"
      puts "result: #{result.class}"
    rescue Exception => e
      raise "caught exception: #{e}"
    end

  end


##############
# try logging in to admin

# test that admin is logged out
  if !(admin_logged_out? browser, false)
    raise "admin already logged in, should not be"
  end

# now log the admin in
  admin_logged_out? browser, true


######################
# go to system / configuration
  navigate_to_system_configuration_page browser


######################
# check that after going to system / configuration, we can see the
# Janrain config items in the left nav:
  $janrain = browser.dt(:xpath, "//dt[@class='label' and contains(.,'Janrain')]")

  if $janrain.blank?
    raise "test failed: Janrain doesn't exist in left nav on Admin"
  else
    puts "able to see Janrain in the left nav"
  end

  $engage = browser.dd(:xpath, "//dd[./a/span[contains(.,'Engage')]]")
  if $janrain.blank?
    raise "test failed: Engage doesn't exist in left nav on Admin"
  else
    puts "able to see Engage in the left nav"
  end


  puts "done with sanity1 tests."

end

