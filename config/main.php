<?php
return array(
	'modules'=>array(
        'office' => array(
            'modules' => array(
            ),
            'import' => array(
				'application.modules.admin.modules.marketing.models.*',
				'application.modules.admin.modules.storegifts.models.*',
				'application.modules.store.models.Horders',
                'application.modules.register.models.*',
				'application.modules.store.models.Orders',
				'application.modules.store.models.Basket',
                'application.modules.admin.modules.roles.models.*',
                'application.modules.admin.modules.packages.models.*',
                'application.modules.admin.modules.finance.models.*',
                'application.modules.admin.modules.matrix.models.*',
                'application.modules.admin.modules.invoice.models.*',
                'application.modules.admin.modules.warehouse.models.*',
            ),
        ),
	),
);
