<?php

namespace KoenHoeijmakers\LaravelArgon2;

use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use RuntimeException;

class Argon2Hasher implements HasherContract
{
    /**
     * Default memory cost factor.
     *
     * @var int
     */
    protected $memoryCost = 1024;
    
    /**
     * Default time cost factor.
     *
     * @var int
     */
    protected $timeCost = 2;
    
    /**
     * Default threads factor.
     *
     * @var int
     */
    protected $threads = 2;
    
    /**
     * Hash the given value.
     *
     * @param  string $value
     * @param  array  $options
     * @return string
     * @throws RuntimeException
     */
    public function make($value, array $options = [])
    {
        $memoryCost = $options['memory_cost'] ?? $this->memoryCost;
        $timeCost = $options['time_cost'] ?? $this->timeCost;
        $threads = $options['threads'] ?? $this->threads;
        
        $hash = password_hash($value, PASSWORD_ARGON2I, [
            'memory_cost' => $memoryCost,
            'time_cost'   => $timeCost,
            'threads'     => $threads,
        ]);
        
        if ($hash === false) {
            throw new RuntimeException('Argon2i hashing not supported.');
        }
        
        return $hash;
    }
    
    /**
     * Check the given plain value against a hash.
     *
     * @param  string $value
     * @param  string $hashedValue
     * @param  array  $options
     * @return bool
     */
    public function check($value, $hashedValue, array $options = [])
    {
        if (strlen($hashedValue) === 0) {
            return false;
        }
        
        return password_verify($value, $hashedValue);
    }
    
    /**
     * Check if the given hash has been hashed using the given options.
     *
     * @param  string $hashedValue
     * @param  array  $options
     * @return bool
     */
    public function needsRehash($hashedValue, array $options = [])
    {
        $memoryCost = $options['memory_cost'] ?? $this->memoryCost;
        $timeCost = $options['time_cost'] ?? $this->timeCost;
        $threads = $options['threads'] ?? $this->threads;
        
        return password_needs_rehash($hashedValue, PASSWORD_ARGON2I, [
            'memory_cost' => $memoryCost,
            'time_cost'   => $timeCost,
            'threads'     => $threads,
        ]);
    }
    
    /**
     * Set the default memory cost factor.
     *
     * @param $memoryCost
     * @return $this
     */
    public function setMemoryCost($memoryCost)
    {
        $this->memoryCost = (int) $memoryCost;
        
        return $this;
    }
    
    /**
     * Set the default time cost factor.
     *
     * @param $timeCost
     * @return $this
     */
    public function setTimeCost($timeCost)
    {
        $this->timeCost = (int) $timeCost;
        
        return $this;
    }
    
    /**
     * Set the default threads factor.
     *
     * @param $threads
     * @return $this
     */
    public function setThreads($threads)
    {
        $this->threads = (int) $threads;
        
        return $this;
    }
}
