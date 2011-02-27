require 'rubygems'
require 'firewatir'
require 'net/http'
require 'uri'

# http://groups.google.com/group/watir-general/browse_thread/thread/26486904e89340b7?pli=1
def page_ok? url
  url = URI.parse(url) 
  http = Net::HTTP.new(url.host, url.port)
  begin
    http.start do
      http.request_get(url.path.empty? ? "/" : url.path) do |res|

        return false unless res.kind_of?(Net::HTTPSuccess)
        # or Net::HTTPOK if you want to exclude 201, 202, 203, 204, 205 and 206

      end
    end
  rescue => e
    puts "Got error: #{e.inspect}"
    return false
  end
  true
end

# see if the Magento index page is serving
if !page_ok?("#{ENV['MGP_ROOT']}1234")
    raise "sanity1: unable to reach #{ENV['MGP_ROOT']}"
end



# browser=FireWatir::Firefox.new
# browser.goto(ENV['MGP_ROOT'])

