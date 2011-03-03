require 'net/http'
require 'uri'


def stop
  raise "stop"
end


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
def admin_logged_out? browser, login_if_out, admin_user="#{ENV['MGP_ADMIN_USER']}", admin_password="#{ENV['MGP_ADMIN_PASSWORD']}"

  result = true

  # start of admin area
  browser.goto("#{ENV['MGP_ROOT']}/index.php/admin")

  # is admin login form showing?
  loginForm = browser.form(:id, "loginForm")

  if loginForm.exists?

    if login_if_out
      # do login
      browser.text_field(:name => "login[username]").set admin_user
      browser.text_field(:name => "login[password]").set admin_password
      loginForm.submit
    end

  else
    result = false
  end

  result

end


def click_engage_configuration_link browser
  $engage = browser.link(:xpath, "//a[./span[contains(.,'Engage')]]")
  $engage.click
end

def click_engage_config_options_link browser
  l = browser.link(:id,"engage_options-head")
  l.click
end

def navigate_to_system_configuration_page browser
  $l = browser.link(:xpath,"//a[contains(span, 'Configuration')]")
  $l.click
end

def save_config browser
  b = browser.button(:xpath, "//button[./span[contains(.,'Save Config')]]")
  b.click
end





