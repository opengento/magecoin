<?php
namespace App\Controller;

use App\Model\Chain;
use App\Model\Transaction;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class IndexController extends Controller
{

    protected $_arUser = [
        "florent" => "231B0997D6BA040DB9728A5CECE5414D636E94C590418C08DFF7DF232861351F",
        "franck" => "98810F8C06E1ABD2CC397641FCACBB4F2C90F1F587C4A96BB808B91B20C7C50B",
        "camille" => "3F56E90B04E7A4B50E3EC2446C13055E9CB1D0851C17C9CE8A52EA3CA76623CC",
        "jacques" => "742B9BB2306EB494BBD3B50593A32CFE621FA9B3228CCFDC119DFD44155B5662",
        "frederic" => "CA68C91636F5C3B099D0490405BA104D5C3857904B14F197FA35F08CFAA12A81",
        "gergory" => "C6A33FD4D2803CF0CA403A172928E1ACB0D7CA7B883D68ACA5C055EE6A84BB18",
        "guirec" => "F28BFD816CA9EB703C89D10B933D1A84E3989C9C1D21F56845F1EB2C750A7F61",
        "sylvain" => "5396FCDF2DDDB5C2931DBFB356021B8CFFB8D6DC5AEEF50693CA8B6BA5AB5760",
        "matias" => "602A0ABB57D67C562BCDA242A6733514C7AAC60E4B179CC6E7FF6F769371A6DA",
        "maxime" => "8FE9C2C44847AB572A08F2C5D689077CA1E07377E82A4F82364E8CE39B162257",
        "dimitri" => "AD2EE1849D40341140B1029652D4F0428F66160A0DA1B73C85CA1B9C1C9B6B20",
    ];


    protected $_chain;

    protected $_serializer;


    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;
    /**
     * @var SessionInterface
     */
    private $session;

    public function __construct(
        \Psr\Log\LoggerInterface $logger,
        SessionInterface $session
    )
    {
        $this->logger = $logger;
        $this->session = $session;
        if(!$this->session->has('chain')) {
            $this->session->set('chain', new \App\Model\Chain());
        }

        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());

        $this->_serializer = new Serializer($normalizers, $encoders);

    }

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {

        /*$this->_chain->createTransaction(
            new Transaction($this->_arUser['florent'], $this->_arUser['franck'], 100)
        );


        $this->_chain->createTransaction(
            new Transaction($this->_arUser['franck'], $this->_arUser['florent'], 50)
        );

        $this->logger->debug("Florent starts mining");

        $this->_chain->minePendingTransactions($this->_arUser['florent']);

        $this->logger->debug("Balance florent: ".$this->_chain->getAddressBalance($this->_arUser['florent']));
        $this->logger->debug("Balance franck: ".$this->_chain->getAddressBalance($this->_arUser['franck']));

        $this->_chain->minePendingTransactions($this->_arUser['florent']);

        $this->logger->debug("Balance florent: ".$this->_chain->getAddressBalance($this->_arUser['florent']));
        $this->logger->debug("Balance franck: ".$this->_chain->getAddressBalance($this->_arUser['franck']));

        $this->logger->debug("Valid: ".$this->_chain->isChainValid());*/

        return $this->render('index.html.twig', [
            'arUser' => $this->_arUser,
            'chain' => $this->getChain()
        ]);
    }

    /**
     * @Route("/balance/{address}")
     * @Method("GET")
     * @param $address
     */
    public function getAddressBalanceAction($address){
        $chain = $this->getChain();
        $balance = $chain->getAddressBalance($address);
        return new JsonResponse([
            'success' => true,
            'balance' => $balance
        ]);
    }

    /**
     * @Route("/transaction", name="transaction")
     * @Method("POST")
     *
     * @param Request $request
     * @param $addressFrom
     * @param $addressTo
     * @param $amount
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createTransactionAction(Request $request){

        $trans = new Transaction($request->get('addressFrom'), $request->get('addressTo'), $request->get('amount'));

        $chain = $this->getChain();

        $chain->createTransaction($trans);

        $this->setChain($chain);

        return new JsonResponse([
            "success" => true,
            "chain" => $this->_serializer->serialize($this->getChain()->getLatestBlock(), 'json'),
        ]);
    }

    /**
     * @Route("/mine", name="mine")
     * @Method("POST")
     * @param Request $request
     */
    public function mine(Request $request){
        $minerAddress = $request->get('minerAddress');
        $chain = $this->getChain();
        $chain->minePendingTransactions($minerAddress);
        $this->setChain($chain);

        return new JsonResponse([
            "success" => true,
            "chain" => $this->_serializer->serialize($this->getChain()->getLatestBlock(), 'json'),
        ]);
    }

    /**
     * @return Chain
     */
    public function getChain(){
        return $this->session->get('chain');
    }

    /**
     * @return Chain
     */
    public function setChain($chain){
        return $this->session->set('chain', $chain);
    }
}