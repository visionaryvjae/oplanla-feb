<x-mail::message>
# New Contact Form Submission

You have received a new message from your website's contact form.

**From:** {{ $data['name'] }}
<br>
**Email:** {{ $data['email'] }}

---

**Message:**

{{ $data['message'] }}

<br>

_This email was sent from the contact form on {{ config('app.name') }}._
</x-mail::message>