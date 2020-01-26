###
@apiVersion 0.0.1
@api {get} /jobs 01 Get the latest jobs
@apiGroup Jobs

@apiDescription
  Get a list of jobs. By default 30 results will be returned. The results are paginated.
  - NOTE: The `closing_date` parameter can be a `null` if the date is already passed.


@apiUse RequestHeader

@apiParam {Integer} [page]		Page number for results. Default is 1.

@apiExample Example URLs
/api/v1/jobs
/api/v1/jobs?page=2

@apiSuccessExample Success-Response 200
{
    "total": 118,
    "per_page": 30,
    "current_page": 1,
    "last_page": 4,
    "from": 1,
    "to": 30,
    "data": [
        {
            "id": 9109
        }
    ]
}
###
