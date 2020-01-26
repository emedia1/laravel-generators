###
@apiVersion 0.0.1
@api {get} /jobs/{jobId} 02 Get job details
@apiGroup Jobs

@apiDescription
  Get details of a given job by ID

@apiUse RequestHeader

@apiParam {Integer} jobId		Job ID

@apiExample Example URLs
/api/v1/jobs/9159

@apiSuccessExample Success-Response 200
{
    "id": 9159
}
###