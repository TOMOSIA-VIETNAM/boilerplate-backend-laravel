<?php

namespace App\Shared\ActivityLog;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\ActivityLogger;
use Spatie\Activitylog\Models\Activity;

class ActivityLogMethod extends ActivityLogger
{
    /**
     * Override log method
     *
     * @param string $description
     * @return Activity|null
     */
    public function log(string $description): ?Activity
    {
        if (auth('admin')->check()) {
            $this->causedBy(auth('admin')->user());
        }
        if (auth('api')->check()) {
            $this->causedBy(auth('api')->user());
        }

        return parent::log($description);
    }

    /**
     * Override performedOn method
     *
     * @param ?Model $model
     * @return static
     */
    public function performedOn(?Model $model): static
    {
        if ($model) {
            $this->getActivity()->subject()->associate($model);
        }

        return $this;
    }

    /**
     * Update columns before saving log
     *
     * @param array $extraData
     * @param static
     */
    public function updateColumns(array $extraData): static
    {
        return $this->tap(function ($activity) use ($extraData) {
            foreach ($extraData as $key => $value) {
                $activity->{$key} = $value;
            }
        });
    }

    /**
     * @param string $message
     * @param ?Model $objectPerformed
     * @param array $properties
     * @param string $name
     * @return Activity|null
     */
    public function logInfo(string $message, ?Model $objectPerformed = null, array $properties = [], string $name = 'default'): ?Activity
    {
        return $this->performedOn($objectPerformed)
            ->withProperties($properties)
            ->event('info')
            ->inLog($name)
            ->log($message);
    }

    /**
     * @param string $message
     * @param ?Model $objectPerformed
     * @param array $properties
     * @param string $name
     * @return Activity|null
     */
    public function logCreated(string $message, ?Model $objectPerformed = null, array $properties = [], string $name = 'default'): ?Activity
    {
        return $this->performedOn($objectPerformed)
            ->withProperties($properties)
            ->event('created')
            ->inLog($name)
            ->log($message);
    }

    /**
     * @param string $message
     * @param ?Model $objectPerformed
     * @param array $properties
     * @param string $name
     * @return Activity|null
     */
    public function logUpdated(string $message, ?Model $objectPerformed = null, array $properties = [], string $name = 'default'): ?Activity
    {
        return $this->performedOn($objectPerformed)
            ->withProperties($properties)
            ->event('updated')
            ->inLog($name)
            ->log($message);
    }

    /**
     * @param string $message
     * @param ?Model $objectPerformed
     * @param string $name
     * @return Activity|null
     */
    public function logDeleted(string $message, ?Model $objectPerformed = null, string $name = 'default'): ?Activity
    {
        return $this->performedOn($objectPerformed)
            ->event('deleted')
            ->inLog($name)
            ->log($message);
    }

    /**
     * @param string $message
     * @param ?Model $objectPerformed
     * @param array $properties
     * @param string $name
     * @return Activity|null
     */
    public function logWarning(string $message, ?Model $objectPerformed = null, array $properties = [], string $name = 'default'): ?Activity
    {
        return $this->performedOn($objectPerformed)
            ->withProperties($properties)
            ->event('warning')
            ->inLog($name)
            ->log($message);
    }

    /**
     * @param string $message
     * @param ?Model $objectPerformed
     * @param array $properties
     * @param string $name
     * @return Activity|null
     */
    public function logError(string $message, ?Model $objectPerformed = null, array $properties = [], string $name = 'default'): ?Activity
    {
        return $this->performedOn($objectPerformed)
            ->withProperties($properties)
            ->event('error')
            ->inLog($name)
            ->log($message);
    }

    /**
     * @param string $message
     * @param ?Model $objectPerformed
     * @param string $name
     * @return Activity|null
     */
    public function logActivated(string $message, ?Model $objectPerformed = null, string $name = 'default'): ?Activity
    {
        return $this->performedOn($objectPerformed)
            ->event('activated')
            ->inLog($name)
            ->log($message);
    }

    /**
     * @param string $message
     * @param ?Model $objectPerformed
     * @param string $name
     * @return Activity|null
     */
    public function logDeactivated(string $message, ?Model $objectPerformed = null, string $name = 'default'): ?Activity
    {
        return $this->performedOn($objectPerformed)
            ->event('deactivated')
            ->inLog($name)
            ->log($message);
    }

    /**
     * @param string $message
     * @param ?Model $objectPerformed
     * @param array $properties
     * @param string $name
     * @return Activity|null
     */
    public function logCustomEvent(string $message, $objectPerformed, string $event, array $properties = [], string $name = 'default'): ?Activity
    {
        return $this->performedOn($objectPerformed)
            ->withProperties($properties)
            ->event($event)
            ->inLog($name)
            ->log($message);
    }
}

