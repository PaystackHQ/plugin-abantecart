<?php

if ( !defined ( 'DIR_CORE' )) {
    header ( 'Location: static_pages/' );
}

class ModelExtensionPaystack extends Model {
    public function getMethod($address) {
        $this->load->language('paystack/paystack');

        if ($this->config->get('paystack_status')) {
            $sql = "SELECT * FROM " . DB_PREFIX . "zones_to_locations
                WHERE location_id = '" . (int)$this->config->get('paystack_location_id') . "'
                AND country_id = '" . (int)$address['country_id'] . "'
                AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')";
            $query = $this->db->query($sql);

            if (!$this->config->get('paystack_location_id')) {
                $status = TRUE;
            } elseif ($query->num_rows) {
                $status = TRUE;
            } else {
                $status = FALSE;
            }

        } else {
            $status = FALSE;
        }

        $method_data = array();

        if ($status) {
            $method_data = array(
            'id'         => 'paystack-payments',
            'title'      => $this->language->get('text_title'),
            'sort_order' => $this->config->get('paystack_sort_order')
            );
        }

        return $method_data;
    }
}
