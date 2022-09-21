<?php

declare(strict_types=1);

namespace OCA\NotesTutorial\Migration;

use Closure;
use OCP\DB\ISchemaWrapper;
use OCP\Migration\SimpleMigrationStep;
use OCP\Migration\IOutput;

class Version000000Date20181013124731 extends SimpleMigrationStep
{

	/**
	 * @param IOutput $output
	 * @param Closure $schemaClosure The `\Closure` returns a `ISchemaWrapper`
	 * @param array $options
	 * @return null|ISchemaWrapper
	 */
	public function changeSchema(IOutput $output, Closure $schemaClosure, array $options)
	{
		/** @var ISchemaWrapper $schema */
		$schema = $schemaClosure();

		if (!$schema->hasTable('notestutorial')) {
			$table = $schema->createTable('notestutorial');
			$table->addColumn('id', 'integer', [
				'autoincrement' => true,
				'notnull' => true,
			]);
			$table->addColumn('title', 'string', [
				'notnull' => true,
				'length' => 200
			]);
			$table->addColumn('user_id', 'string', [
				'notnull' => true,
				'length' => 200,
			]);
			$table->addColumn('content', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('physical', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('namelt', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('idfile', 'text', [
				'notnull' => true,
				'default' => ''
			]);

			$table->setPrimaryKey(['id']);
			$table->addIndex(['user_id'], 'notestutorial_user_id_index');
		}



		if (!$schema->hasTable('agreements')) {
			$table = $schema->createTable('agreements');
			$table->addColumn('id', 'integer', [
				'autoincrement' => true,
				'notnull' => true,
			]);
			$table->addColumn('user_id', 'string', [
				'notnull' => true,
				'length' => 200,
			]);
			$table->addColumn('idfile', 'text', [
				'notnull' => true,
				'default' => ''
			]);


	
	
			$table->addColumn('title', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('content', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('physical', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('namelt', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('description', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('comments', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('outsourcing', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('it', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('valid_since', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('valid_until', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('form', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('first_party', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('second_party', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('physical_location', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('materiality', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('last_risk_assessment_date', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('relation', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('date', 'text', [
				'notnull' => true,
				'default' => ''
			]);
		

			$table->setPrimaryKey(['id']);
			$table->addIndex(['user_id'], 'agreements_user_id_index');
		}

		if (!$schema->hasTable('contracts')) {
			$table = $schema->createTable('contracts');
			$table->addColumn('id', 'integer', [
				'autoincrement' => true,
				'notnull' => true,
			]);
			$table->addColumn('user_id', 'string', [
				'notnull' => true,
				'length' => 200,
			]);
			$table->addColumn('idfile', 'text', [
				'notnull' => true,
				'default' => ''
			]);


	
			$table->addColumn('name', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('title', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('registration_number_contract', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('description', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('date', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('in_force_until', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('counterparties', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('corporate_owner', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('personal_owner', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('it', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('outsourcing', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('materiality', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('last_risk_assessment_date', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('document_type', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('physical_location', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('comments', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('relation', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('namelt', 'text', [
				'notnull' => true,
				'default' => ''
			]);

			$table->setPrimaryKey(['id']);
			$table->addIndex(['user_id'], 'contracts_user_id_index');
		}


		if (!$schema->hasTable('mbdecisions')) {
			$table = $schema->createTable('mbdecisions');
			$table->addColumn('id', 'integer', [
				'autoincrement' => true,
				'notnull' => true,
			]);
			$table->addColumn('user_id', 'string', [
				'notnull' => true,
				'length' => 200,
			]);
			$table->addColumn('idfile', 'text', [
				'notnull' => true,
				'default' => ''
			]);


	
			$table->addColumn('title', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('date_of_the_document', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('physical_location', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('validity', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('form', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('document_status', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('participants', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('decision_type', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('relation', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('namelt', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('registration_number_cdrmbd', 'text', [
				'notnull' => true,
				'default' => ''
			]);

			$table->setPrimaryKey(['id']);
			$table->addIndex(['user_id'], 'mbdecisions_user_id_index');
		}


		if (!$schema->hasTable('ceoresolutions')) {
			$table = $schema->createTable('ceoresolutions');
			$table->addColumn('id', 'integer', [
				'autoincrement' => true,
				'notnull' => true,
			]);
			$table->addColumn('user_id', 'string', [
				'notnull' => true,
				'length' => 200,
			]);
			$table->addColumn('idfile', 'text', [
				'notnull' => true,
				'default' => ''
			]);


	
			$table->addColumn('name', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('title', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('date_of_the_document', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('physical_location', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('validity', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('form', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('document_status', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('registration_number_cdro', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('participants', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('order_type', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('relation', 'text', [
				'notnull' => true,
				'default' => ''
			]);

			$table->setPrimaryKey(['id']);
			$table->addIndex(['user_id'], 'ceoresolutions_user_id_index');
		}


		if (!$schema->hasTable('sbresolutions')) {
			$table = $schema->createTable('sbresolutions');
			$table->addColumn('id', 'integer', [
				'autoincrement' => true,
				'notnull' => true,
			]);
			$table->addColumn('user_id', 'string', [
				'notnull' => true,
				'length' => 200,
			]);
			$table->addColumn('idfile', 'text', [
				'notnull' => true,
				'default' => ''
			]);


	
			$table->addColumn('name', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('title', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('date_of_the_document', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('physical_location', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('validity', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('form', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('document_status', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('participants', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('registration_number_cdrsbd', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('decision_type', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('relation', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('namelt', 'text', [
				'notnull' => true,
				'default' => ''
			]);

			$table->setPrimaryKey(['id']);
			$table->addIndex(['user_id'], 'sbresolutions_user_id_index');
		}


		if (!$schema->hasTable('outsourcingagreements')) {
			$table = $schema->createTable('outsourcingagreements');
			$table->addColumn('id', 'integer', [
				'autoincrement' => true,
				'notnull' => true,
			]);
			$table->addColumn('user_id', 'string', [
				'notnull' => true,
				'length' => 200,
			]);
			$table->addColumn('idfile', 'text', [
				'notnull' => true,
				'default' => ''
			]);


	
			$table->addColumn('name', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('title', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('date', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('description', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('comments', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('outsourcing', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('outsourcing_function_audit_date', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('parties_related_to_the_company_who_also_use_this_service', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('valid_since`, `valid_until', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('form', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('physical_location', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('materiality', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('nature_of_function', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('last_risk_assessment_date', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('last_risk_assessment_result', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('namelt`, `basis_for_materiality', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('location_of_data', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('location_of_services', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('transfer_of_data', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('bank_of_lithuania_approval_date', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('bank_of_lithuania_notification_date', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('is_the_service_provider_related_to_uab_pervesk', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('agreement_approved_by', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('governing_law_of_the_agreement', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('subcontractors', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('service_provider_address`, `service_provider_legal_entity_code', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('service_provider_name', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('service_provider_parent_company', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('service_provider_substitutability_assessment_result', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('alternative_service_providers', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('does_this_function_support_business_operations_critical', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('price_of_agreement', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('events_when_outsourced_function_was_not_provided_at_agreed_level', 'text', [
				'notnull' => true,
				'default' => ''
			]);	

			$table->setPrimaryKey(['id']);
			$table->addIndex(['user_id'], 'outsourcingagreements_user_id_index');
		}


		if (!$schema->hasTable('policiesandinstructions')) {
			$table = $schema->createTable('policiesandinstructions');
			$table->addColumn('id', 'integer', [
				'autoincrement' => true,
				'notnull' => true,
			]);
			$table->addColumn('user_id', 'string', [
				'notnull' => true,
				'length' => 200,
			]);
			$table->addColumn('idfile', 'text', [
				'notnull' => true,
				'default' => ''
			]);


	
			$table->addColumn('name', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('title', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('type_pi', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('approval_date', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('responsible_unit', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('validity', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('owner', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('relation', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('namelt', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('area	', 'text', [
				'notnull' => true,
				'default' => ''
			]);	

			$table->setPrimaryKey(['id']);
			$table->addIndex(['user_id'], 'policiesandinstructions_user_id_index');
		}


		if (!$schema->hasTable('sentorreceiveddocuments	')) {
			$table = $schema->createTable('sentorreceiveddocuments	');
			$table->addColumn('id', 'integer', [
				'autoincrement' => true,
				'notnull' => true,
			]);
			$table->addColumn('user_id', 'string', [
				'notnull' => true,
				'length' => 200,
			]);
			$table->addColumn('idfile', 'text', [
				'notnull' => true,
				'default' => ''
			]);


	
			$table->addColumn('name', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('title', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('date_receipt_date', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('sender', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('recipient', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('recipient_employee', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('document_form', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('document_type', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('delivery_method', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('date_of_the_document', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('physical_location', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('registration_number_td', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('document_organizer', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('direction', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('relation', 'text', [
				'notnull' => true,
				'default' => ''
			]);
			$table->addColumn('namelt', 'text', [
				'notnull' => true,
				'default' => ''
			]);	

			$table->setPrimaryKey(['id']);
			$table->addIndex(['user_id'], 'sentorreceiveddocuments_user_id_index');
		}

		if (!$schema->hasTable('flowupload_directories')) {
			$table = $schema->createTable('flowupload_directories');
			$table->addColumn('id', 'integer', [
				'autoincrement' => true,
				'notnull' => true,
			]);
			$table->addColumn('user_id', 'string', [
				'notnull' => true,
				'length' => 200,
			]);
			$table->addColumn('directory', 'text', [
				'notnull' => true,
				'default' => ''
			]);

			$table->setPrimaryKey(['id']);
			$table->addIndex(['user_id'], 'flowupload_user_id_index');
		}

		return $schema;
	}
}
