# design directories, may not exist on Magento when this script is run
default_layout=$MAGENTO_HOME/app/design/frontend/default/default/layout/
default_template=$MAGENTO_HOME/app/design/frontend/default/default/template/

# create them if they don't
if [ -d $default_layout ]; then
	echo "$default_layout directory exists, not creating"
else
	echo "$default_layout directory doesn't exist, creating"
	mkdir $default_layout
fi

if [ -d $default_template ]; then
	echo "$default_template directory exists, not creating"
else
	echo "$default_template directory doesn't exist, creating"
	mkdir $default_template
fi

# symlink everything we need from the project into the correct Magento dirs.
ln -f -s $MAGENTO_CODE_HOME/app/etc/modules/Janrain_Engage.xml $MAGENTO_HOME/app/etc/modules/
ln -f -s $MAGENTO_CODE_HOME/app/code/local/Janrain $MAGENTO_HOME/app/code/local/
ln -f -s $MAGENTO_CODE_HOME/app/design/frontend/default/default/layout/* $MAGENTO_HOME/app/design/frontend/default/default/layout/
ln -f -s $MAGENTO_CODE_HOME/app/design/frontend/default/default/template/* $MAGENTO_HOME/app/design/frontend/default/default/template/
ln -f -s $MAGENTO_CODE_HOME/app/locale/en_US/* $MAGENTO_HOME/app/locale/en_US/


