<?php
namespace App\Repositories;

use App\Contracts\CourseContract;
use App\Models\Course;
use App\Traits\UploadAble;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
/**
 * Class CourseManagementRepository
 *
 * @package \App\Repositories
 */
class CourseManagementRepository implements CourseContract
{
    use UploadAble;
   /**
     * @param array $params
     * @return mixed
     */
    public function updateStatus(array $params){
        $collection = collect($params)->except('_token');
       $id =  $collection['id'];
        $Course = Course::findOrFail($id);
        $status = ( $Course->is_verified == 1 ) ? 0 : 1;
        $Course->is_verified = $status;
        $Course->save();
        return $Course;
    }
}