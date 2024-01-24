<?php

return new class
{
    public function up(): void
    {
        echo 'hello up migrate';
    }

    public function down(): void
    {
        echo 'hello down migrate';
    }
};