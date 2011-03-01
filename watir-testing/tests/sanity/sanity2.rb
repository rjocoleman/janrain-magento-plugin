require 'rubygems'
require 'firewatir'
require "#{ENV['MAGENTO_1d5_PLUGIN']}/watir-testing/tests/ruby_lib/lib.rb"

puts ""
puts ""
puts "sanity2 tests..."

## these tests assume that we've already logged in to the admin

[
        # Magento admin page
        "#{ENV['MGP_ROOT']}/index.php/admin",

        # Magento admin/config: a particular page which crashed
        "#{ENV['MGP_ROOT']}/index.php/admin/system_config/index/key/60c6b91937cadc95bff54c0cc4fb8a9b/"

].each do |url|

  begin
    puts "trying #{url}"
    result = try_url "#{url}"
    puts "result: #{result.class}"
  rescue Exception => e
    raise "caught exception: #{e}"
  end

end


puts "done with sanity2 tests."
puts ""
puts ""


