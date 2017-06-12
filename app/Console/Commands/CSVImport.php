<?php

namespace App\Console\Commands;

use App\Country;
use App\Fund;
use App\Location;
use App\OrganisationType;
use App\Provider;
use App\ProvisionType;
use App\Region;
use Carbon\Carbon;
use Illuminate\Console\Command;
use League\Csv\Reader;
use SplFileObject;

class CSVImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import-funds-from-csv';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parses fund information from a CSV file and imports them into the database.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $csv = Reader::createFromPath(__DIR__ . '/refund_may_2017.csv');

        /*
         * 0 => "provider"
         * 1 => "website"
         * 2 => "fund_name"
         * 3 => "region"
         * 4 => "country"
         * 5 => "location"
         * 6 => "organisation_type"
         * 7 => "provision"
         * 8 => "investment_term"
         * 9 => "loans_rate"
         *10 => "min_size"
         *11 => "max_size"
         *12 => "focus"
         *13 => "last_updated"
         *14 => "status"
         */

        //get 25 rows starting from the 11th row
        $csv->setDelimiter(',');
        $csv->setEnclosure('"');
        $csv->setEscape('\\');
        $csv->setFlags(SplFileObject::READ_AHEAD | SplFileObject::SKIP_EMPTY);
        $csv->setOffset(1);

        $rows = $csv->fetchAll();

        $headers = $csv->fetchOne();

        $this->info('Funds extracted from CSV file...');

        // Delete all existing funds
        Fund::all()->each(function($item, $key) {
            $item->delete();
        });

        $this->info('Existing funds deleted...');

        foreach ($rows as $row)
        {
            $row = array_combine($headers, $row);

            $fund = new Fund;

            $fund->website         = trim($row['website']);
            $fund->name            = trim($row['name']);
            $fund->investment_term = $row['investment_term'];
            $fund->loans_rate      = $row['loans_rate'];
            $fund->min_size        = str_replace(['£', ','], '', $row['min_size']);
            $fund->max_size        = str_replace(['£', ','], '', $row['max_size']);
            $fund->focus           = trim($row['focus']);
            $fund->status          = $row['status'];
            $fund->created_at      = Carbon::createFromTime(0, 0, 0)->setDate(2017, 5, 31)->timestamp;
            $fund->updated_at      = Carbon::createFromTime(0, 0, 0)->setDate(2017, 5, 31)->timestamp;

            // Providers
            if ( ! empty($row['provider']))
            {
                $row['provider'] = trim($row['provider']);

                if ( ! Provider::whereName($row['provider'])->exists())
                {
                    $fund->provider_id = Provider::create([
                        'name' => $row['provider']
                    ])->id;
                }
                else
                {
                    $fund->provider_id = Provider::whereName($row['provider'])->first()->id;
                }
            }

            $fund->save();

            // Regions
            if ( ! empty($row['region']))
            {
                $region_ids = [];

                foreach (explode(',', $row['region']) as $region)
                {
                    $region = trim($region);

                    if ( ! Region::whereName($region)->exists())
                    {
                        $region_ids[] = Region::create([
                            'name' => $region
                        ])->id;
                    }
                    else
                    {
                        $region_ids[] = Region::whereName($region)->first()->id;

                    }
                }

                $fund->regions()->attach($region_ids);
            }

            // Countries
            if ( ! empty($row['country']))
            {
                $country_ids = [];

                foreach (explode(',', $row['country']) as $country)
                {
                    $country = trim($country);

                    if ( ! Country::whereName($country)->exists())
                    {
                        $country_ids[] = Country::create([
                            'name' => $country
                        ])->id;
                    }
                    else
                    {
                        $country_ids[] = Country::whereName($country)->first()->id;
                    }
                }

                $fund->countries()->attach($country_ids);
            }

            // Locations
            if ( ! empty($row['location']))
            {
                $location_ids = [];

                foreach (explode(',', $row['location']) as $location)
                {
                    $location = trim($location);

                    if ( ! Location::whereName($location)->exists())
                    {
                        $location_ids[] = Location::create([
                            'name' => $location
                        ])->id;
                    }
                    else
                    {
                        $location_ids[] = Location::whereName($location)->first()->id;
                    }
                }

                $fund->locations()->attach($location_ids);
            }

            // Organisation Types
            if ( ! empty($row['organisation_type']))
            {
                $organisation_type_ids = [];

                foreach (explode(',', $row['organisation_type']) as $organisation_type)
                {
                    $organisation_type = trim($organisation_type);

                    if ( ! OrganisationType::whereName($organisation_type)->exists())
                    {
                        $organisation_type_ids[] = OrganisationType::create([
                            'name' => $organisation_type
                        ])->id;
                    }
                    else
                    {
                        $organisation_type_ids[] = OrganisationType::whereName($organisation_type)->first()->id;
                    }
                }

                $fund->organisation_types()->attach($organisation_type_ids);
            }

            $row['provision'] = $row['provider_type'];

            // Provision Types
            if ( ! empty($row['provision']))
            {
                $provision_type_ids = [];

                foreach (explode(',', $row['provision']) as $provision_type)
                {
                    $provision_type = trim($provision_type);

                    if ( ! ProvisionType::whereName($provision_type)->exists())
                    {
                        $provision_type_ids[] = ProvisionType::create([
                            'name' => $provision_type
                        ])->id;
                    }
                    else
                    {
                        $provision_type_ids[] = ProvisionType::whereName($provision_type)->first()->id;
                    }
                }

                $fund->provision_types()->attach($provision_type_ids);
            }
        }

        $this->info('Done!');
    }
}
