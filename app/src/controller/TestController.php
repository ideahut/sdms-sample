<?php
namespace App\controller;

use Exception;
use ReflectionClass;
use ReflectionObject;
use ReflectionMethod;


use \Ideahut\sdms\Common;

use \Ideahut\sdms\base\BaseController;
use \Ideahut\sdms\object\Result;
use \Ideahut\sdms\object\CodeMsg;
use \Ideahut\sdms\object\Page;
use \Ideahut\sdms\object\Admin;

use \Ideahut\sdms\entity\Entity;
use \Ideahut\sdms\entity\EntityDao;
use \Ideahut\sdms\entity\EntityTime;

use \Ideahut\sdms\repository\CrudRepository;

use \Ideahut\sdms\util\ObjectUtil;
use \Ideahut\sdms\util\RequestUtil;
use \Ideahut\sdms\util\SequenceUtil;

use \App\entity\Access;
use \App\entity\User;
use \App\entity\Test;

use \Ideahut\sdms\refproxy\Proxy;
use \App\iface\iTest;
use \App\iface\IFaceHandler;

use \App\repository\AccessRepository;
use \App\repository\UserRepository;

use Ideahut\sdms\annotation as IDH;

use \Ideahut\sdms\exception\ResultException;

/**
	@IDH\Document(ignore = true)
 */
class TestController extends BaseController 
{
	
	/**
     * @IDH\Method({"POST", "GET"})
     * @IDH\Access(public = true)
     */
	public function helo() {
		//$ref = new ReflectionClass(Access::class);
		//$obj = new ReflectionObject(new Access());
    	//$prop = $obj->getProperty("updatedAt"); 
    	//var_dump($prop->isPublic());
		
		//$access = new Access(["id"=>1,"createdAt"=>new \DateTime()]);
		//var_dump($access->createdAt);

		//$meta = $this->getEntityManager()->getClassMetadata(Access::class);
        //var_dump($meta->getAssociationMappings());

		//$obj = new CodeMsg();
		//$obj->code=1;
		//$t = ObjectUtil::formatObject($obj);
		//var_dump($arr);

		//$str = "return [a=>\"1\", \"b\"=>2];";
		//$str = "a=\"test\"    &    b=1";
		//parse_str(null, $out);
		//var_dump($out);
		//$b=[];
		//var_dump(is_array($b) && count($b) !== 0);

		//$b = [1,2,3];
		//$b = ["a"=>0, "b"=>1, "c"=>2];
		//array_splice($b, 0, 1);
		//unset($b[0]);
		//var_dump(array_keys($b) === range(0, count($b) - 1));
		//var_dump(is_array($b));

		//$dao = new EntityDao($this, Access::class);		
		//$dao->filter("or__name__eq=tom|id=1|user__name__contains=tes|user__access__name__contains=tes");
        //var_dump($dao->where());
        //var_dump(substr("1234", 0, -1));

        //$dao = Test::dao($this);
        //$t = $dao->page(new Page(1, 2, true))->filter("name__like=co")->select();
        
        //$meta = $this->getEntityManager()->getClassMetadata(User::class);
        //var_dump($meta->fieldMappings['id']);

        //$dao = Test::dao($this, $this->getLogger());
        //$t = $dao->map("id");
        //$t = new \App\access\AdminAccess(["a"=>1]);
        //var_dump($t);
		
		//$t = implode("__", array_slice(["a", "b", "c"], 1));
		//$t = array_slice(["a", "b", "c"], 0, -1);
		
		//$class  = new ReflectionClass("\\App\\project\\controller\\AccessController");
		//$method = $class->getMethod("login");
		//$t = RequestUtil::validate($this, "AccessValidator->login");
		//$request = $this->getRequest();
		//$t = null;
		
		//var_dump($request->getMediaType());
		//$a = (array)simplexml_load_string($request->getBody()->getContents());
		//$t = ObjectUtil::arrayToObject($a, Admin::class);

		//var_dump($o);

		//$a = ObjectUtil::formatObject($o);
		//var_dump($a);
		//$x = self::arrayToXML($a);//new \SimpleXMLElement("<object/>");
		//$this->array_to_xml($a, $x);
		//array_walk_recursive($a, array ($x, 'addChild'));
		//var_dump($x->asXML());

		//$t = RequestUtil::bodyToObject($request, Admin::class);
		//$a = 1;
		//$t = $a . " - ok";

		//$t = Test::dao($this)->pk(1)->get();
		//$t->name="ubah";
		//$t->save($this);
		//$c = Access::class;
		//$t = is_subclass_of($c, Entity::class);
		//var_dump($t);

		//$t = interface_exists(Access::class);

		$t = null;

		$repo = User::repo(UserRepository::class, $this);
		$t = $repo->get(1);
		//$t = $repo->getByUserName("test");
		//$t = $repo->getByStatusAndRole(1, 1);

		return Result::SUCCESS($t);
	}


	/**
     * REPO
     *     
     * @IDH\Method({"POST", "GET"})
     * @IDH\Access(public = true)
     */
	public function repo() {
		$t = null;

		//$repo = User::repo(UserRepository::class, $this);
		//$t = $repo->get(1);
		//$t = $repo->getByUserName("test");
		//$t = $repo->countByStatusAndRole(1, 1);

		/*$user = new User([
			"username" => "coba",
			"password" => "rahasia",
			"fullname" => "coba",
			"status" => 1,
			"role" => 1
		]);*/
		/*try {
			$user = $repo->get(18);
			$t = $repo->save($user);
			return Result::SUCCESS($t);
		} catch (Exception $e) {
			return Result::ERROR("10", $e->getMessage());
		}*/

		/*try {
			$t = [];
			for ($i = 33; $i < 40; $i++) {
				$user = $repo->get($i);
				$user = new User([
					"username" => "coba_" . $i,
					"password" => "rahasia",
					"fullname" => "coba",
					"status" => 1,
					"role" => 1
				]);
				if (!isset($user)) {
					continue;
				}
				array_push($t, $user);	
			}
			$t = $repo->saveAll($t);
			return Result::SUCCESS($t);
		} catch (Exception $e) {
			return Result::ERROR("10", $e->getMessage());
		}*/
		
		//$t = $repo->findAll(["-username"], new Page(1,3, true));
		//$t = $repo->findByFullname("coba", ["-username"]);
		//$t = $repo->findAllByFullname("coba", ["username"], new Page(1, 2, false));
		//$t = $repo->findAllByFullname("coba", ["username"], 2, 0);
		
		/*try {
			$t = $repo->findAllById([1,2,30]);
			return Result::SUCCESS($t);
		} catch (Exception $e) {
			return Result::ERROR("10", $e->getMessage());
		}*/


		//$t = $repo->findAll();
		//$t = $repo->deleteById([29,30]);
		//$l = $repo->findAllById([31, 33]);
		//$t = $repo->deleteAll($l);

		//$l = $repo->findById(34);
		//$t = $repo->delete($l);

		//$t = $repo->map(["username"]);
		//$t = $repo->mapUsername(["-username"]);
		//$t = $repo->mapByFullname("coba");
		//$t = $repo->mapUsernameByFullname("coba", ["username"], 2, 4);

		
		$repo = Access::repo(AccessRepository::class, $this);
		//$t = $repo->findAll(null,new Page(1,2));
		//$t = $repo->get("1e071371-6ca0-11e9-b5aa-3c970ebf4a1e");
		//$t = $repo->getByKey("1e071371-6ca0-11e9-b5aa-3c970ebf4a1e");
		$t = $repo->counter("INPUT", "OK");


		return Result::SUCCESS($t);
	}

	/**
     * HELO IFACE
     * @IDH\Method({"POST", "GET"})
     * @IDH\Access(public = true)
     */
	public function helo_iface() {
		//$proxy = Proxy::newProxyInstance(iTest::class, new IFaceHandler());
		//$handler = Proxy::getInvocationHandler($proxy);
		//var_dump($handler);
		//$t = $proxy->halo();
		
		//$body  = $this->getRequest()->getBody();
		//$prop  = new \ReflectionProperty(get_class($body), "stream");
		//$prop->setAccessible(true);
		//$stream = $prop->getValue($body);
		//var_dump($stream);
		//$t=null;

		$options = new \HessianOptions();
		$options->version = 2;
		$url = 'http://127.0.0.1:58081/hessian/test';
		$proxy = new \HessianClient($url, $options);
        //var_dump($proxy);
		$t = $proxy->halo();
		return Result::SUCCESS($t);

		
	}


	/**
     * HESSIAN JAVA
     *     
     * @IDH\Method({"POST", "GET"})
     * @IDH\Access(public = true)
     */
	public function hessian__java() {
		$options = new \HessianOptions();
		$options->version = 2;
		$url = 'http://127.0.0.1:8086/hessian/TestService';
		$proxy = new \HessianClient($url, $options);
        $t = $proxy->text("ini dipanggil dari php");
		return Result::SUCCESS($t);		
	}



	/**
	 * ANNOTATION
	 *
	 * @IDH\Method({"POST", "GET"})
     * @IDH\Access(public = true)
	 */
	public function annotation() {
		//$b=\Doctrine\Common\Annotations\AnnotationRegistry::loadAnnotationClass(\App\annotation\Formatter::class);
    	//var_dump($b);$classAnnotations = $annotationReader->getClassAnnotations($reflectionClass);
    	//\Doctrine\Common\Annotations\AnnotationRegistry::registerLoader('class_exists');
    	//$reader = new AnnotationReader();
		//$formatter = $reader->getClassAnnotation(new \ReflectionClass(TestObject::class), Formatter::class);
		//var_dump($formatter);
		//$classAnnotations = $reader->getClassAnnotations(new \ReflectionClass(TestObject::class));
		//var_dump($classAnnotations);

		//$t = $reader->getClassAnnotation(new \ReflectionClass(TestController::class), IDH\Method::class);
		//$t = ObjectUtil::scanAnnotation(new \ReflectionClass(TestController::class), IDH\Method::class);
		//$t = $t[IDH\Method::class];
		//var_dump(get_class($t));
		return Result::SUCCESS($t);
	}

	/**
	 	VALIDATION
	 
	 	@IDH\Method({"POST", "GET"})
     	@IDH\Access(public = true)
     	@IDH\Validator(
     		@IDH\ClassMethod(class = "App\validator\AccessValidator", method = "login")
     	)	 
	 */
	public function validation() {
		RequestUtil::validate($this);
		$t = null;
		return Result::SUCCESS($t);	
	}
	
}
