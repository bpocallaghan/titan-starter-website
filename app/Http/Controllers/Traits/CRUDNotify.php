<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Http\Request;

trait CRUDNotify
{
    /**
     * Get Model class name, add space before all capital letters
     *
     * @param $model
     * @return mixed
     */
    private function formatModelName($model)
    {
        return preg_replace('/(?<!\ )[A-Z]/', ' $0', class_basename($model));
    }

    /**
     * Create Entry
     *
     * @param $model
     * @param $inputs
     * @return mixed
     */
    public function createEntry($model, $inputs)
    {
        $row = $model::create($inputs);

        if ($row) {
            notify()->success('Successfully',
                'A new ' . $this->formatModelName($model) . ' has been created');
        }
        else {
            notify()->error('Oops', 'Something went wrong');
        }

        return $row;
    }

    /**
     * @param $model
     * @param $inputs
     * @return mixed
     */
    public function updateEntry($model, $inputs)
    {
        $response = $model->update($inputs);

        notify()->success('Successfully',
            'The ' . $this->formatModelName($model) . ' has been updated');

        return $model;
    }

    /**
     * @param         $model
     * @param Request $request
     */
    public function deleteEntry($model, Request $request)
    {
        // check if ids match (cant type random ids)
        if ($request->get('_id') == $model->id) {
            if ($model->delete() >= 1) {
                notify()->success('Successfully',
                    'The ' . $this->formatModelName($model) . ' has been removed');
            }
            else {
                notify()->error('Oops',
                    'We could not find the ' . $this->formatModelName($model) . ' to delete');
            }
        }
        else {
            notify()->error('Oops',
                'The ' . $this->formatModelName($model) . ' id does not match');
        }
    }
}