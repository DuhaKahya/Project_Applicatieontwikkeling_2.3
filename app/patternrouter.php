<?php

namespace App;

use Error;

class PatternRouter
{
    private function stripParameters($uri)
    {
        if (str_contains($uri, '?')) {
            $uri = substr($uri, 0, strpos($uri, '?'));
        }
        return $uri;
    }

    public function route($uri): void
    {
        $uri = $this->stripParameters($uri);

        $segments = explode('/', $uri);
        // Assuming the first segment is always the controller/entity type
        $entityType = $segments[0] ?? null;
        $action = $segments[1] ?? 'index'; // Default to 'index' if not specified

        // Construct the controller name based on the first segment or default to HomeController
        $controllerName = !empty($entityType) ? ucfirst($entityType) . 'Controller' : 'HomeController';
        $controllerName = "App\\Controllers\\" . $controllerName;

        // Default method name is the action, adjust below as needed
        $methodName = $action;

        // Parameters for the method, start empty and fill based on the action
        $params = [];

        // Special handling for actions with expected parameters
        switch ($action) {
            case 'edit':
            case 'create':
                // For '/entityType/edit/id' or '/entityType/create'
                // Assuming edit/create actions are handled by a specific controller (ManageController)
                $controllerName = "App\\Controllers\\ManageController";
                $methodName = $action . 'Entity';
                $params = [$entityType, $segments[2] ?? null]; // Pass entity type and id (if any)
                break;
            case 'processDelete':
                // For '/entityType/processDelete' with type and id expected to be passed as GET parameters
                $controllerName = "App\\Controllers\\ManageController";
                $type = $_GET['type'] ?? null;
                $id = $_GET['id'] ?? null;
                if ($type !== null && $id !== null) {
                    $params = [$type, $id]; // Pass type and id from GET parameters
                } else {
                    // Handle error or missing parameters case here
                    http_response_code(400);
                    echo "Missing type or id for deletion.";
                    return;
                }
                break;
            default:
                // For other actions, check if additional segments/parameters are present
                $params = array_slice($segments, 2);
                break;
        }

        // Check if controller and method exist
        if (!class_exists($controllerName) || !method_exists($controllerName, $methodName)) {
            http_response_code(404);
            echo "Page not found.";
            return;
        }

        try {
            $controllerObj = new $controllerName();
            // Call the method with parameters dynamically
            call_user_func_array([$controllerObj, $methodName], $params);
        } catch (Error $e) {
            http_response_code(500);
            echo "An error occurred: " . $e->getMessage();
        }
    }
}
