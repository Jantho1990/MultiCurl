# MultiCurl
This is a curl class which makes extensive use of
curl_multi functionality.

## Why do this?
Because I've had need for a curl wrapper which can process
handles without waiting for all of them to be completed. To accomplish this,
MultiCurl uses curl_multi to run the curl requests, and as handles are still
being made the existing requests are polled to determine if they are complete.
If any are, then (after error handling) any attached callback functions may be
run on the request result. By not having to wait for every handle to finish
executing before processing the results, considerable time may be saved in
cases of very large numbers of queries.

`Currently, this is very much a work in progress and should
not be used in any project.`
