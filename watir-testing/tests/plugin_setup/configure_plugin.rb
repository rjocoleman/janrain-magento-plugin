require 'rubygems'
require 'firewatir'
require "#{ENV['MAGENTO_1d5_PLUGIN']}/watir-testing/tests/ruby_lib/lib.rb"


# test Engage apikey (example is bh-test01)...
MGP_ENGAGE_APIKEY="1ea372282118fd1574f6fdd1e3961cec868b21f4"

# ...should result in all of the following:
MGP_ENGAGE_REALM="bh-test01.rpxnow.com"
MGP_ENGAGE_REALM_SCHEME="https"
MGP_ENGAGE_APP_ID="kknlmbekkcenihlcfnld"
MGP_ENGAGE_ADMIN_URL="https://rpxnow.com/relying_parties/bh-test01"
MGP_ENGAGE_SOCIAL_PUB="twitter"
MGP_ENGAGE_ENABLED_PROVIDERS="aol, google, yahoo, openid, twitter"


def configure_plugin_tests browser

  puts "configure_plugin tests..."

  # try logging in to admin
  admin_logged_out? browser, true

  # insert the API key, submit, see that the correct Engage values are shown.
  configure_plugin browser

  # try placing the auth widget
  configure_engage_authentication_link browser


  puts "done with configure_plugin tests."

end


def configure_plugin browser

  # go to system / configuration
  navigate_to_system_configuration_page browser

  # go to engage config page
  click_engage_configuration_link browser

  # insert API key
  insert_engage_api_key browser, MGP_ENGAGE_APIKEY

  # save the config
  save_config browser

  # show the account data - not really a test, just nice to show while test is running
  show_account_info browser

  # test Account Info values
  test_account_info_values browser

end



def element_exists? browser, element, xpath
  case element
    when "span"
      return browser.span(:xpath, xpath).exists?
    when "p"
      return browser.p(:xpath, xpath).exists?
    else
      raise "element_with_text_exists: #{element} not implemented"
  end
end

def wait_until_loaded browser, element, xpath, timeout=20 # , sleep_for=0.1
  start_time = Time.now
  until (element_exists? browser, element, xpath) do
    puts"waiting..."
    sleep 0.2
    if Time.now - start_time> timeout
      raise RuntimeError, "wait_until_loaded: timed out after #{timeout} seconds"
    end
  end
  puts "element found for xpath #{xpath}"
end


def configure_engage_authentication_link browser


  # cms / widgets /
  navigate_to_cms_widgets browser

  # click add new widget instance
  button_click_by_onclick_segment browser, 'admin/widget_instance/new/key'


  # first page:

  # type engage auth
  pulldown_by_name browser, "type", "Engage Authentication"

  # package theme
  pulldown_by_name browser, "package_theme", "default / default"


  # click continue button
  # submit_widget_form browser
  button_click_by_onclick_segment browser, 'admin/widget_instance/edit/type'



  # next page:

  # set widget instance title
  set_widget_instance_title browser



  # assign to store views
  pulldown_by_name browser, "store_ids[]", "All Store Views"

  # save widget, wait for success message
  widget_save browser


  # add layout update
  button_click_by_onclick_segment browser, 'WidgetInstance.addPageGroup({})'

  # display on
  pulldown_by_name browser, "widget_instance[0][page_group]", "Simple Product"


  # wait for "Please Select Block Reference First"
  element = "p"
  text = "Please Select Block Reference First"
  xpath = "//#{element}[@class='nm' and contains(./small,'#{text}')]"
  wait_until_loaded browser, element, xpath  #, 0.3

  # pause...not sure why this is needed after the above wait is done
  sleep 2

  # block reference
  pulldown_by_name browser, "widget_instance[0][simple_products][block]", "Main Content Area"


  # save widget, wait for success message
  widget_save browser


  # todo - maybe try changing from small to large


  # test1: does the widget now show up on a product page?
  browser.goto("#{ENV['MGP_ROOT']}/furniture/living-room/ottoman.html")

  widget_link = browser.link(:xpath, "//a[./div[contains(.,'Or log in with')]]")

  if !widget_link.exists?
    raise "unable to see widget link on ottoman page."
  else
    puts "able to see the widget on the ottoman page."
  end


  # test2: does it work if it's clicked?
  #  (maybe that should fall under a different test set)


end


def widget_save browser

  #save and continue edit
  button_click_by_onclick_segment browser, 'saveAndContinueEdit()'

  # wait for the javascript to finish
  element = "span"
  text = "The widget instance has been saved."
  xpath = "//#{element}[.[contains(.,'#{text}')]]"
  wait_until_loaded browser, element, xpath #, 0.3

  # todo - just to be sure, try taking out
  sleep 1

end