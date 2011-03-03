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



# general Magento navigation
def navigate_to_cms_widgets browser
  $l = browser.link(:xpath,"//a[contains(span, 'Widgets')]")
  $l.click
end

def navigate_to_system_configuration_page browser
  $l = browser.link(:xpath,"//a[contains(span, 'Configuration')]")
  $l.click
end


#########################
# actions for our plugin


# general
def save_config browser
  b = browser.button(:xpath, "//button[./span[contains(.,'Save Config')]]")
  b.click
end



# widget stuff
def click_add_new_widget_instance browser
  button = browser.button(:xpath, "//button[contains(@onclick, 'admin/widget_instance/new/key')]")
  button.click
end

def click_add_layout_update browser
  button = browser.button(:xpath, "//button[contains(@onclick, 'WidgetInstance.addPageGroup({})')]")
  button.click
end

def click_save_and_continue_edit browser
  button = browser.button(:xpath, "//button[contains(@onclick, 'saveAndContinueEdit()')]")
  button.click
end

def pulldown_assign_to_store_views browser
  d = browser.select_list(:name, "store_ids[]")
  d.select("All Store Views")
end

def pulldown_package_theme browser
  d = browser.select_list(:name, "package_theme")
  d.select("default / default")
end

def pulldown_widget_type browser
  d = browser.select_list(:name, "type")
  d.select("Engage Authentication")
end



def set_widget_instance_title browser
  browser.text_field(:name => "title").set 'Engage Widget'
end

def submit_widget_form browser
  widgetForm = browser.form(:id, "edit_form")
  widgetForm.submit
end

def widget_form_continue browser
  button = browser.button(:xpath, "//button[contains(@onclick, 'admin/widget_instance/edit/type')]")
  button.click
end


# engage config stuff
def click_engage_configuration_link browser
  $engage = browser.link(:xpath, "//a[./span[contains(.,'Engage')]]")
  $engage.click
end

def click_engage_config_options_link browser
  l = browser.link(:id,"engage_options-head")
  l.click
end

def insert_engage_api_key browser, apikey
  t = browser.text_field(:id, "engage_options_apikey")
  t.set(apikey)
end

def show_account_info browser
  l = browser.link(:id,"engage_accountdata-head")
  l.click
end

def test_account_info_values browser

  [MGP_ENGAGE_REALM,
   MGP_ENGAGE_REALM_SCHEME,
   MGP_ENGAGE_APP_ID,
   MGP_ENGAGE_ADMIN_URL,
   MGP_ENGAGE_SOCIAL_PUB,
   MGP_ENGAGE_ENABLED_PROVIDERS
  ].each do |lookup|

    result = browser.table(:xpath, "//table[./tbody/tr/td[contains(.,'#{lookup}')]]")
    if !result.exists?
      raise "unable to see [#{lookup}] for configured Engage account"
    else
      puts "for configured Engage account: can see [#{lookup}]"
    end

  end

end





