<?php

namespace ACFBentveld\XML\Exceptions;

use Exception;

class UnknownTransformException extends Exception
{
    public static function unknownAlias(string $alias): self
    {
        return new static("Could not find a default transformer with the alias $alias. Try using `->with()` with the class instead");
    }
}
