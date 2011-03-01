require 'rubygems'
require 'firewatir'
require "#{ENV['MAGENTO_1d5_PLUGIN']}/watir-testing/tests/ruby_lib/lib.rb"

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

$browser = Watir::Browser.new

# start of admin area
$browser.goto("#{ENV['MGP_ROOT']}/index.php/admin")

# is admin login form showing?
loginForm = $browser.form(:id, "loginForm")

if loginForm.exists?

  # do login
  $browser.text_field(:name => "login[username]").set "#{ENV['MGP_ADMIN_USER']}"
  $browser.text_field(:name => "login[password]").set "#{ENV['MGP_ADMIN_PASSWORD']}"
  loginForm.submit

else

  # this should not happen - we are killing cookies on every test
  raise "admin is logged in"

end



######################
# check that we can get to system / configuration
$l = $browser.link(:xpath,"//a[contains(span, 'Configuration')]")
$l.click



######################
# see if we can see the Janrain config items in the left nav:
$janrain = $browser.dt(:xpath, "//dt[@class='label' and contains(.,'Janrain')]")

if $janrain.blank?
  raise "test failed: Janrain doesn't exist in left nav on Admin"
else
  puts "able to see Janrain in the left nav"
end

$engage = $browser.dd(:xpath, "//dd[./a/span[contains(.,'Engage')]]")
if $janrain.blank?
  raise "test failed: Engage doesn't exist in left nav on Admin"
else
  puts "able to see Engage in the left nav"
end




puts "done with sanity1 tests."


