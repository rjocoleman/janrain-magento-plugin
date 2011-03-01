require 'net/http'
require 'uri'


# http://groups.google.com/group/watir-general/browse_thread/thread/26486904e89340b7?pli=1
def try_url url
  url = URI.parse(url)
  http = Net::HTTP.new(url.host, url.port)

  http.start do
    http.request_get(url.path.empty? ? "/" : url.path) do |result|

      unless result.kind_of?(Net::HTTPSuccess)
        # or Net::HTTPOK if you want to exclude 201, 202, 203, 204, 205 and 206
        raise "call to #{url} was not successful; result: #{result.class}"
      end

      return result
    end
  end

end


# browser = running Watir browser
# login_if_out = do a login (only if not logged in)
# returns true if admin is logged out
def admin_logged_out? browser, login_if_out

  result = true

  # start of admin area
  browser.goto("#{ENV['MGP_ROOT']}/index.php/admin")

  # is admin login form showing?
  loginForm = browser.form(:id, "loginForm")

  if loginForm.exists?

    if login_if_out
      # do login
      browser.text_field(:name => "login[username]").set "#{ENV['MGP_ADMIN_USER']}"
      browser.text_field(:name => "login[password]").set "#{ENV['MGP_ADMIN_PASSWORD']}"
      loginForm.submit
    end

  else
    result = false
  end

  result

end