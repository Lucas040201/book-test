<?php

namespace App\Docs;

use OpenApi\Annotations as OA;

/**
 * @OA\OpenApi(
 *     @OA\Info(
 *         title="Book API",
 *         version="1.0.0",
 *         description="A test for CSC Group",
 *         @OA\Contact(
 *             email="lucas.mendes.dev@outlook.com.br"
 *         ),
 *         @OA\License(
 *             name="MIT",
 *             url="https://opensource.org/licenses/MIT"
 *         )
 *     ),
 *     @OA\Server(
 *         url="http://localhost/api",
 *         description="Developmente Server"
 *     )
 * )
 */
class ApiDocumentation
{

}
