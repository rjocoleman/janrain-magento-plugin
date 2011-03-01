require 'rubygems'
require 'firewatir'
require 'net/http'
require 'uri'

# http://groups.google.com/group/watir-general/browse_thread/thread/26486904e89340b7?pli=1
def try_url url
  url = URI.parse(url)
  http = Net::HTTP.new(url.host, url.port)

  http.start do
    http.request_get(url.path.empty? ? "/" : url.path) do |res|

      return res

      # return false unless res.kind_of?(Net::HTTPSuccess)
      # or Net::HTTPOK if you want to exclude 201, 202, 203, 204, 205 and 206

    end
  end

end

puts ""
puts ""
puts "sanity1 tests..."

# see if the Magento index page is serving
begin
  puts "trying #{ENV['MGP_ROOT']}"
  result = try_url "#{ENV['MGP_ROOT']}"
  puts "result: #{result.class}"
rescue Exception => e
  raise "caught exception: #{e}"
end

puts "done with sanity1 tests."
puts ""
puts ""


