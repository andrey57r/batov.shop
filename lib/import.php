<?php

declare(strict_types = 1);

namespace Batov\Shop;

use Batov\Shop\LaptopTable;
use Batov\Shop\ModelOptionTable;
use Batov\Shop\OptionTable;
use Batov\Shop\VendorTable;
use Batov\Shop\ModelTable;
use Batov\Shop\LaptopOptionTable;

class Import
{

    private const dataSets = 'https://raw.githubusercontent.com/andrey57r/DataSets/master/laptops.csv';
    private array $optionKeys = [
        'size',
        'screen',
        'cpu',
        'storage',
        'gpu',
        'ram',
        'os',
        'version',
        'weight',
    ];
    private array $options = [];

    public function main(): void
    {
        $vendors = $this->parseCsv();
        $this->insertOptions();
        $this->insertVendors($vendors);
    }

    private function insertVendors(array $vendors): void
    {
        foreach ($vendors as $name => $models) {
            $addResult = VendorTable::add([
                'NAME' => $name,
                'SLUG' => $this->slugify($name),
            ]);

            $this->insertModels($models, $addResult->getId());
        }
    }

    private function insertModels(array $models, int $vendorId): void
    {
        foreach ($models as $name => $laptops) {
            $addResult = ModelTable::add([
                'NAME' => $name,
                'SLUG' => $this->slugify($name),
                'VENDOR_ID' => $vendorId,
            ]);

            $this->insertLaptops($laptops, $addResult->getId());
            $this->insertModelOptions($laptops, $addResult->getId());
        }
    }

    private function insertLaptops(array $laptops, int $modelId): void
    {
        $maxYear = (int)date('Y');
        $minYear = $maxYear - 10;

        foreach ($laptops as $name => $options) {
            $price = (int)round(end($options));

            $addResult = LaptopTable::add([
                'NAME' => $name,
                'SLUG' => $this->slugify($name),
                'MODEL_ID' => $modelId,
                'PRICE' => $price,
                'YEAR' => rand($minYear, $maxYear),
            ]);

            $this->insertLaptopOptions($options, $addResult->getId());
        }
    }

    private function insertLaptopOptions(array $options, int $laptopId): void
    {
        [
            $screenSize,
            $screen,
            $cpu,
            $ram,
            $storage,
            $gpu,
            $os,
            $version,
            $weight,
            $price,
        ] = $options;

        foreach ($this->optionKeys as $name) {
            $value = $$name;

            if (is_null($value)) {
                continue;
            }

            LaptopOptionTable::add([
                'LAPTOP_ID' => $laptopId,
                'OPTION_ID' => $this->options[$name],
                'VALUE' => $value,
            ]);
        }
    }

    private function insertModelOptions(array $laptops, int $modelId): void
    {
        $list = [];

        foreach ($laptops as $name => $options) {
            [
                $screenSize,
                $screen,
                $cpu,
                $ram,
                $storage,
                $gpu,
                $os,
                $version,
                $weight,
                $price,
            ] = $options;

            $list['size'][$screenSize] = $screenSize;
            $list['screen'][$screen] = $screen;
            $list['cpu'][$cpu] = $cpu;
            $list['ram'][$ram] = $ram;
            $list['storage'][$storage] = $storage;
            $list['gpu'][$gpu] = $gpu;
            $list['os'][$os] = $os;
            $list['weight'][$weight] = $weight;
        }

        foreach ($list as $name => $values) {
            foreach ($values as $key => $value) {
                ModelOptionTable::add([
                    'MODEL_ID' => $modelId,
                    'OPTION_ID' => $this->options[$name],
                    'VALUE' => $value,
                ]);
            }
        }
    }

    private function insertOptions(): void
    {
        foreach ($this->optionKeys as $name) {
            $addResult = OptionTable::add([
                'NAME' => strtoupper($name),
            ]);

            $this->options[$name] = $addResult->getId();
        }
    }

    private function parseCsv(): array
    {
        $content = file_get_contents(self::dataSets);
        $list = array_slice(explode("\n", $content), 1, 300);

        $store = [];
        foreach ($list as $item) {
            [
                $vendor,
                $model,
                $category,
                $screenSize,
                $screen,
                $cpu,
                $ram,
                $storage,
                $gpu,
                $os,
                $osVersion,
                $weight,
                $price,
            ] = str_getcsv($item);

            if (empty($vendor)) {
                continue;
            }

            $store[$vendor][$model][$screenSize . ' ' . $cpu . ' ' . $ram . ' ' . $storage] = [
                $screenSize,
                $screen,
                $cpu,
                $ram,
                $storage,
                $gpu,
                $os,
                $osVersion,
                $weight,
                $price,
            ];
        }

        return $store;
    }

    private function slugify(string $name): string
    {
        return \CUtil::translit($name, 'ru', [
            'replace_space' => '-',
            'replace_other' => '-',
        ]);
    }

}