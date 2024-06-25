<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class permissions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        $permissions =  get_user_permission();
        if($permissions[0]){
          $modules_ids = $permissions[0]['modules_ids'];
        }else{
          $modules_ids = array();
        }


        if($request->segments() && count($request->segments())>1){
            switch ($request->segments()[0]) {
                case "users":
                    if($request->segments()[1] == 'create'|| $request->segments()[0] == 'users'){
                        if(in_array("1/add", $modules_ids)){
                            return $next($request);
                          }else{
                            return redirect()->route('login');  
                          }
                    }elseif(in_array("1/".$request->segments()[1], $modules_ids)){
                          return $next($request);
                    }else{
                          return redirect()->route('login');
                    }
                  break;
                case "permissions":
                    if($request->segments()[1] == 'create' || $request->segments()[0] == 'permissions'){
                        if(in_array("2/add", $modules_ids)){
                            return $next($request);
                          }else{
                            return redirect()->route('login');  
                          }
                    }elseif(in_array("2/".$request->segments()[1], $modules_ids)){
                          return $next($request);
                    }else{
                          return redirect()->route('login');
                    }
                  break;
               
                case "settings":
                    if($request->segments()[1] == 'create' || $request->segments()[0] == 'settings' ){
                     
                        if(in_array("3/add", $modules_ids)){
                            return $next($request);
                          }else{
                            return redirect()->route('login');  
                          }

                    }elseif(in_array("3/".$request->segments()[1], $modules_ids)){
                            return $next($request);
                    }else{
                            return redirect()->route('login');
                    }
                    break;
                case "customers":
                    if($request->segments()[1] == 'create' || $request->segments()[0] == 'customers' ){
                        if(in_array("4/add", $modules_ids)){
                            return $next($request);
                          }else{
                            return redirect()->route('login');  
                          }
                    }elseif(in_array("4/".$request->segments()[1], $modules_ids)){
                          return $next($request);
                    }else{
                          return redirect()->route('login');
                    }
                    break;
                    case "categories":
                      if($request->segments()[1] == 'create' || $request->segments()[0] == 'categories' ){
                          if(in_array("5/add", $modules_ids)){
                              return $next($request);
                            }else{
                              return redirect()->route('login');  
                            }
                      }elseif(in_array("5/".$request->segments()[1], $modules_ids)){
                            return $next($request);
                      }else{
                            return redirect()->route('login');
                      }
                      break;
                      case "themes":
                        if($request->segments()[1] == 'create' || $request->segments()[0] == 'themes' ){
                            if(in_array("6/add", $modules_ids)){
                                return $next($request);
                              }else{
                                return redirect()->route('login');  
                              }
                        }elseif(in_array("6/".$request->segments()[1], $modules_ids)){
                              return $next($request);
                        }else{
                              return redirect()->route('login');
                        }
                        break;
                        case "styles":
                          if($request->segments()[1] == 'create' || $request->segments()[0] == 'styles' ){
                              if(in_array("7/add", $modules_ids)){
                                  return $next($request);
                                }else{
                                  return redirect()->route('login');  
                                }
                          }elseif(in_array("7/".$request->segments()[1], $modules_ids)){
                                return $next($request);
                          }else{
                                return redirect()->route('login');
                          }
                          break;
                          case "colors":
                            if($request->segments()[1] == 'create' || $request->segments()[0] == 'colors' ){
                                if(in_array("8/add", $modules_ids)){
                                    return $next($request);
                                  }else{
                                    return redirect()->route('login');  
                                  }
                            }elseif(in_array("8/".$request->segments()[1], $modules_ids)){
                                  return $next($request);
                            }else{
                                  return redirect()->route('login');
                            }
                            break;
                            case "locations":
                              if($request->segments()[1] == 'create' || $request->segments()[0] == 'locations' ){
                                  if(in_array("9/add", $modules_ids)){
                                      return $next($request);
                                    }else{
                                      return redirect()->route('login');  
                                    }
                              }elseif(in_array("9/".$request->segments()[1], $modules_ids)){
                                    return $next($request);
                              }else{
                                    return redirect()->route('login');
                              }
                              break;
                              case "paintings":
                                if((isset($request->segments()[2]) && $request->segments()[2] == 'edit') || $request->segments()[0] == 'paintings' ){
                                    if(in_array("10/add", $modules_ids)){
                                        return $next($request);
                                      }else{
                                        return redirect()->route('login');  
                                      }
                                }elseif(in_array("10/".$request->segments()[1], $modules_ids)){
                                      return $next($request);
                                }else{
                                      return redirect()->route('login');
                                }
                              break;
                              case "addons":
                                if((isset($request->segments()[2]) && $request->segments()[2] == 'edit') || $request->segments()[0] == 'addons' ){
                                    if(in_array("11/add", $modules_ids)){
                                        return $next($request);
                                      }else{
                                        return redirect()->route('login');  
                                      }
                                }elseif(in_array("11/".$request->segments()[1], $modules_ids)){
                                      return $next($request);
                                }else{
                                      return redirect()->route('login');
                                }
                              break;
                              case "certificates":
                                if((isset($request->segments()[2]) && $request->segments()[2] == 'edit') || $request->segments()[0] == 'certificates' ){
                                    if(in_array("12/add", $modules_ids)){
                                        return $next($request);
                                      }else{
                                        return redirect()->route('login');  
                                      }
                                }elseif(in_array("12/".$request->segments()[1], $modules_ids)){
                                      return $next($request);
                                }else{
                                      return redirect()->route('login');
                                }
                              break;
                                
                    default:
                    return $next($request);
              }
        }elseif($request->segments()){
            switch ($request->segments()[0]) {
                case "users":
                    if(in_array("1/view", $modules_ids)){
                      return $next($request);
                    }else{
                        return redirect()->route('login');
                    }
                  break;
                case "permissions":
                    if(in_array("2/view", $modules_ids)){
                        return $next($request);
                      }else{
                          return redirect()->route('login');
                      }
                  break;
                case "settings":
                    if(in_array("3/view", $modules_ids)){
                        return $next($request);
                      }else{
                          return redirect()->route('login');
                      }
                    break;
                case "customers":
                  if(in_array("4/view", $modules_ids)){
                      return $next($request);
                    }else{
                        return redirect()->route('login');
                    }
                  break;
                case "categories":
                    if(in_array("5/view", $modules_ids)){
                        return $next($request);
                      }else{
                          return redirect()->route('login');
                      }
                break;
                case "themes":
                  if(in_array("6/view", $modules_ids)){
                      return $next($request);
                    }else{
                        return redirect()->route('login');
                    }
                break;
                case "styles":
                  if(in_array("7/view", $modules_ids)){
                      return $next($request);
                    }else{
                        return redirect()->route('login');
                    }
                break;
                case "colors":
                  if(in_array("8/view", $modules_ids)){
                      return $next($request);
                    }else{
                        return redirect()->route('login');
                    }
                break;
                case "locations":
                  if(in_array("9/view", $modules_ids)){
                      return $next($request);
                    }else{
                        return redirect()->route('login');
                    }
                break;
                case "paintings":
                  if(in_array("10/view", $modules_ids)){
                      return $next($request);
                    }else{
                        return redirect()->route('login');
                    }
                break;
                case "addons":
                  if(in_array("11/view", $modules_ids)){
                      return $next($request);
                    }else{
                        return redirect()->route('login');
                    }
                break;
                case "certificates":
                  if(in_array("12/view", $modules_ids)){
                      return $next($request);
                    }else{
                        return redirect()->route('login');
                    }
                break;
                default:
                return $next($request);
              
          }
        
        }
       return $next($request);
    }
}