<?php

namespace Drupal\autocomplete_entity_display\Controller;

use Drupal\Core\Ajax\AfterCommand;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\RemoveCommand;
use Drupal\Core\Controller\ControllerBase;

/**
 * Returns responses for autocomplete_entity_display routes.
 */
class AutocompleteEntityDisplayController extends ControllerBase {

  /**
   * Builds the response.
   */
  public function dataAjaxResponse($entity_type, $entity_id) {

    if (empty($entity_type) || empty($entity_id)) {
      return (new AjaxResponse())->addCommand(new RemoveCommand('#tag-project_information'));
    }

    try {
      $entity = \Drupal::entityTypeManager()->getStorage($entity_type)->load($entity_id);
      $title = '(no title)';

      if (!empty($entity->field_project_title->value)) {
        $title = strip_tags($entity->field_project_title->value);
        //Client
        $client_id = strip_tags($entity->field_individual_client->target_id);
        $client = \Drupal::entityTypeManager()->getStorage('user')->load($client_id);
        $client_display_name = strip_tags($client->field_full_name->display_name);
        //Governorate
        $land_info_id = strip_tags($entity->field_land_information->target_id);
        $land_info = \Drupal::entityTypeManager()->getStorage('land_info')->load($land_info_id);
        $governorate_id = strip_tags($land_info->field_governorate->target_id);
        $governorate = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->load($governorate_id);
        $governorate_display = strip_tags($governorate->name->value);


        //$governorate = strip_tags($entity->field_land_information->field_governorate->value);
        //$location = strip_tags($entity->field_land_information->field_location->value);
      }

      $response = new AjaxResponse();

      $response->addCommand(new RemoveCommand(
        '#tag-project_information'
      ));
      $response->addCommand(new AfterCommand(
        '#edit-field-project-id-wrapper',
        "<div id='tag-project_information'>
          <strong>Title:</strong> $title <br>
          <strong>Client:</strong> $client_display_name <br>
           <strong>Governorate:</strong> $governorate_display
        </div>"

      ));

      return $response;
    }
    catch (\Exception $exception) {
      return (new AjaxResponse())->addCommand(new RemoveCommand('#tag-project_information'));
    }
  }

}
