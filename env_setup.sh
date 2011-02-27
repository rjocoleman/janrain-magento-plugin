Janrain Engage Magento Plugin

This repository assumes all contents will be blaced in magento/app/code/local and that the module will be activated through an XML file at magento/app/etc/modules/Janrain_Engage.xml with the following contents:

<config>
	<modules>
		<Janrain_Engage>
			<active>true</active>
			<codePool>local</codePool>
			<depends>
                <Mage_Core />
                <Mage_Customer />
            </depends>
		</Janrain_Engage>
	</modules>
</config>

